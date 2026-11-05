<?php
namespace App\Http\Controllers;


use Smalot\PdfParser\Parser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiChatController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:10000',
        ]);

        $apiKey = config('services.openrouter.api_key');

        if (!$apiKey) {
            return response()->json([
                'error' => 'OpenRouter API Key غير موجود'
            ], 500);
        }

        // المستند الذي يختاره Laravel تلقائياً
        $documentPath = public_path(
            'assets/t.pdf'
        );

        $subject = 'Database Systems';

        if (!file_exists($documentPath)) {
            return response()->json([
                'error' => 'المستند غير موجود داخل Laravel'
            ], 404);
        }

        try {

            // قراءة المستند من Laravel
            $parser = new Parser();

            $pdf = $parser->parseFile($documentPath);

            $documentText = $pdf->getText();

            if (trim($documentText) === '') {
                return response()->json([
                    'error' => 'المستند لا يحتوي على نص قابل للاستخراج'
                ], 422);
            }

            $documentText = mb_substr(
                $documentText,
                0,
                30000
            );

            // إرسال المستند والسؤال إلى AI
            $model = 'openrouter/free';

            $response = Http::connectTimeout(10)
                ->timeout(90)
                ->withToken($apiKey)
                ->post(
                    'https://openrouter.ai/api/v1/chat/completions',
                    [
                        'model' => $model,

                        'messages' => [
                            [
                                'role' => 'system',
                                'content' => "
أنت مدرس ذكي في منصة تعليمية.

المادة: {$subject}

هذا محتوى المحاضرة:
{$documentText}

أجب عن سؤال الطالب اعتماداً على المحاضرة.
اشرح بطريقة سهلة ومبسطة مع أمثلة.
إذا لم تجد المعلومة في المحاضرة أخبر الطالب بذلك.
"
                            ],
                            [
                                'role' => 'user',
                                'content' => $request->question
                            ]
                        ]
                    ]
                );

            if (!$response->successful()) {

                Log::error('OpenRouter Error', [
                    'status' => $response->status(),
                    'body' => $response->json()
                ]);

                return response()->json([
                    'error' => 'OpenRouter API Error',
                    'details' => $response->json()
                ], $response->status());
            }

            $answer = $response->json(
                'choices.0.message.content'
            );

            return response()->json([
                'subject' => $subject,
                'document' => basename($documentPath),
                'question' => $request->question,
                'answer' => $answer,
                'model' => $response->json('model') ?? $model
            ]);

        } catch (\Throwable $e) {

            Log::error('AI Error', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'حدث خطأ أثناء معالجة السؤال',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
