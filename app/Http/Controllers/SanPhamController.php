<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SanPhamController extends Controller
{
    public function search(Request $request){
        $noi_dung_tim = '%'. $request->noi_dung_tim . '%';
        $data   =  SanPham::where('ten_san_pham', 'like', $noi_dung_tim)
                            ->orWhere('mo_ta_ngan', 'like', $noi_dung_tim)
                            ->get();
        return response()->json([
            'data'  => $data
        ]);
    }

    public function searchNguoiDung(Request $request){
        $noi_dung_tim = '%'. $request->noi_dung_tim . '%';
        $data   =  SanPham::where('ten_san_pham', 'like', $noi_dung_tim)
                            ->orWhere('mo_ta_ngan', 'like', $noi_dung_tim)->where('tinh_trang', 1)
                            ->get();
        return response()->json([
            'data'  => $data
        ]);
    }

    public function chuyenTrangThaiBan(Request $request)
    {

        $id_chuc_nang = 12;

        $tinh_trang = $request->tinh_trang == 1 ? 0 : 1;
        SanPham::find($request->id)->update([
            'tinh_trang'    =>  $tinh_trang
        ]);

        return response()->json([
            'status' => true,
            'message' => "Đã đổi tình trạng sản phẩm". $request->ten_san_pham . " thành công.",
        ]);
    }

    public function chuyenNoiBat(Request $request)
    {

        $id_chuc_nang = 13;

        $is_noi_bat = $request->is_noi_bat == 1 ? 0 : 1;
        SanPham::find($request->id)->update([
            'is_noi_bat'    =>  $is_noi_bat
        ]);

        return response()->json([
            'status' => true,
            'message' => "Đã đổi tình trạng sản phẩm". $request->ten_san_pham . " thành công.",
        ]);
    }

    public function update(Request $request){

        $id_chuc_nang = 11;

        SanPham::find($request->id)->update([
            'ten_san_pham'  =>$request->ten_san_pham,
            'slug_san_pham'  =>$request->slug_san_pham,
            'so_luong'   =>$request->so_luong,
            'hinh_anh'   =>$request->hinh_anh,
            'mo_ta_ngan'   =>$request->mo_ta_ngan,
            'mo_ta_chi_tiet'   =>$request->mo_ta_chi_tiet,
            'tinh_trang'  =>$request->tinh_trang,
            'gia_ban'  =>$request->gia_ban,
            'gia_khuyen_mai'  =>$request->gia_khuyen_mai,
            'tag'               =>$request->tag,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Đã sửa đổi thông tin ". $request->ten_san_pham . " thành công.",
        ]);
    }

    public function chuyenFlashSale(Request $request)
    {

        $id_chuc_nang = 14;

        $is_flash_sale = $request->is_flash_sale == 1 ? 0 : 1;
        SanPham::find($request->id)->update([
            'is_flash_sale'    =>  $is_flash_sale
        ]);

        return response()->json([
            'status' => true,
            'message' => "Đã đổi tình trạng sản phẩm". $request->ten_san_pham . " thành công.",
        ]);
    }

    public function getData()
    {

        $id_chuc_nang = 7;

        $data = SanPham::get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function getDataNew()
    {
        $data = SanPham::orderBy('id', 'DESC')->take(10)->get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function getDataNoiBat()
    {
        $data = SanPham::where('is_noi_bat',1)->take(10)->get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function getDataFlashSale()
    {
        $data = SanPham::where('is_flash_sale',1)->take(5)->get();
        return response()->json([
            'data' => $data
        ]);
    }



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

            $client = GlobalGemini::client($this->getTokenGemini());
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

    public function store(Request $request)
    {

        $id_chuc_nang = 8;

        SanPham::create([
            'ten_san_pham'      =>$request->ten_san_pham,
            'slug_san_pham'     =>$request->slug_san_pham,
            'so_luong'          =>$request->so_luong,
            'hinh_anh'          =>$request->hinh_anh,
            'mo_ta_ngan'        =>$request->mo_ta_ngan,
            'mo_ta_chi_tiet'    =>$request->mo_ta_chi_tiet,
            'tinh_trang'        =>$request->tinh_trang,
            'gia_ban'           =>$request->gia_ban,
            'gia_khuyen_mai'    =>$request->gia_khuyen_mai,
            'sao_danh_gia'      =>$request->sao_danh_gia,
            'tag'               =>$request->tag,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Đã thêm mới sản phẩm". $request->ten_san_pham . " thành công.",
        ]);
    }

    public function checkSlug(Request $request)
    {

        $id_chuc_nang = 9;

        $slug = $request->slug_san_pham;
        $check = SanPham::where('slug_san_pham', $slug)->first();
        if($check){
            return response()->json([
                'status' => false,
                'message' => "Slug này đã tồn tại.",
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Có thể thêm danh mục này.",
            ]);
        }
    }

    public function xoaSP(Request $request)
    {

        $id_chuc_nang = 10;

        SanPham::find($request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => "Đã xóa sản phẩn". $request->ten_san_pham . " thành công.",
        ]);
    }

    public function layThongTinSanPham($id)
    {
        $data   = SanPham::where('id', $id)->where('tinh_trang', 1)->first();
        if($data) {
            return response()->json([
                'status'  => true,
                'data'    => $data
            ]);
        } else {
            return response()->json([
                'status'     => false,
                'message'    => "Sản phẩm không tồn tại trong hệ thống"
            ]);
        }
    }

    public function layThongTinSanPhamTuDanhMuc($id_danh_muc)
    {
        $data   = SanPham::where('id_danh_muc', $id_danh_muc)->where('tinh_trang', 1)->get();
        if(count($data) > 0) {
            return response()->json([
                'status'  => true,
                'data'    => $data
            ]);
        } else {
            return response()->json([
                'status'     => false,
                'message'    => "Danh mục không có bất kỳ sản phẩm nào"
            ]);
        }
    }

    public function layThongTinSanPhamDaiLy($id_dai_ly)
    {
        $data   = SanPham::where('id_dai_ly', $id_dai_ly)->where('tinh_trang', 1)->get();
        if(count($data) > 0) {
            return response()->json([
                'status'  => true,
                'data'    => $data
            ]);
        } else {
            return response()->json([
                'status'     => false,
                'message'    => "Danh mục không có bất kỳ sản phẩm nào"
            ]);
        }
    }

}
