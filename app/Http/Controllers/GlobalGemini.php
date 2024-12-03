<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GlobalGemini extends Controller
{

    public function genatorAI(Request $request)
    {
        try {
            $ten_san_pham = $request->input('ten_san_pham');
            $prompt = "Hãy Ví Dụ Bạn Là Chuyên Viên Viết Content Có Kinh Nghiệm 10 Năm Viết Bài Giới thiệu về sản phẩm $ten_san_pham:\n\n";
            $prompt .= "\nDữ liệu trả về bắt buộc là dạng phân bố cục html như <h1> <br> ....";
            $prompt .= "\nĐộ dài phải dài và chi tiết , có thể sử dụng chữ in đậm , icon , gạch đầu dòng....";
            $prompt .= "\nCó hướng dẫn sử dụng ,Bảo quản, cam kết đổi trả 7 ngày và một số cam kết khác ....";
            $prompt .= "\nBạn có thể sử dụng thông tin dưới đây để tạo một giới thiệu đầy đủ và hấp dẫn cho sản phẩm của mình. ";
            $prompt .= "\nNếu không có dữ liệu nào trong yêu cầu, bạn có thể bỏ qua phần tương ứng trong giới thiệu.";
            $prompt .= "\n\nDữ liệu đầu vào từ yêu cầu:\n" . json_encode($request->all());

            // $client = GlobalGemini::client($this->getTokenGemini());
            $globalGemini = new GlobalGemini();
            $client = $globalGemini->client($this->getTokenGemini());
            $result = $client->geminiPro()->generateContent($prompt);
            return response()->json([
                'status' => true,
                'data' => $result->text(),
                'message' => "Tạo Thành Công",
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
