<?php
header('Content-Type: text/html; charset=utf-8');
//access_token page
$access_token = "EAAUK1vC5SK4BAGf6f5VGIPqKXbGZCLxgz3h5rhy1igZBQQmfZC75xdwHNe836uhbMeS2NyvLu9ZCjsxrTLvmXCn4ZAZCoA5r36XUFbicqomZBxJZAE4ZAHkHcQW9UyT3eRkypFNrMoGIA1hYDo2RUcwqnAR3iODpi7bFTcZBpMaRO16AZDZD";
//token xac nhan
//$verify_token = "vanloc354";
$verify_token = "12345678988";
//khong biet
$hub_verify_token = null;
//ket noi csdl
//$conn = mysqli_connect('localhost', 'vanlocte_nha', 'vanloc354', 'vanlocte_nha') or die ('Không thể kết nối tới database');
//mysqli_set_charset($conn, 'utf8');

//check token hub
if (isset($_REQUEST['hub_mode'])) {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];
    if ($hub_verify_token === $verify_token) {
        header("HTTP/1.1 200 OK");
        echo $challenge;
        die;
    }
}

$input = json_decode(file_get_contents('php://input'), true);

$sender = $input['entry'][0]['messaging'][0]['sender']['id'];
$message = isset($input['entry'][0]['messaging'][0]['message']['text']) ? $input['entry'][0]['messaging'][0]['message']['text'] : "";

if ($message) {

    $url = "https://graph.facebook.com/v2.6/me/messages?access_token=" . $access_token;

    $message = strtoupper($message);
    $message_new = explode(" ", $message);
    if ($message == 'HI' || $message == "HELLO") {
        $text = "✅ Chào bạn,\u000A 🔥 Đây là hệ thống tra cứu hóa đơn tự động. \u000A 🔥 Hãy gõ lệnh 🎲 HELP để xem các câu lệnh nhé. \u000A 🔥 Hoặc gõ lệnh để biết cú pháp nhé.";
//    } elseif ($message_new[0] == "TRACUU") {
//        if (count($message_new) == 5) {
//            //lay cac thong tin tien
//            $sql2 = "SELECT main.TongTien, main.TienDien, main.TienNuoc, phong.PhongSo, main.TienMang, main.TienXe, phong.TienPhong, main.TenCPK, main.TienCPK FROM main, phong WHERE main.idPhong = '$message_new[1]' AND phong.TienPhong = '$message_new[2]' AND main.Thang = '$message_new[3]' AND main.Nam = '$message_new[4]' AND phong.id = main.idPhong";
////            $sql = "SELECT * FROM main WHERE idPhong = '$message_new[1]' AND id = $message_new[2] AND Thang = '$message_new[3]' AND Nam = '$message_new[4]'";
//            $result = mysqli_query($conn, $sql2);
//            if (mysqli_num_rows($result) > 0) {
//                //lay iduser
//                $sql3 = "SELECT * FROM phong WHERE id = '$message_new[1]'";
//                $result3 = mysqli_query($conn, $sql3);
//                $row3 = mysqli_fetch_array($result3);
//                $iduser = $row3['idUser'];
//
//                //lay tien rac trong setting
//                $sql4 = "SELECT * FROM setting WHERE idUser = '$iduser'";
//                $result4 = mysqli_query($conn, $sql4);
//                $row4 = mysqli_fetch_array($result4);
//
//                $row = mysqli_fetch_array($result);
//                if ($row['TongTien'] <> 0) {
//                    $text = "✅ Hóa đơn phòng " . $row['PhongSo'] . " tháng " . $message_new[3] . "/" . $message_new[4] .
//                        "\u000A 💲 Tiền phòng: " . number_format($row['TienPhong']) . " VND" .
//                        "\u000A 💲 Tiền điện: " . number_format($row['TienDien']) . " VND";
//                    if ($row['TienNuoc'] <> 0)
//                        $text .= "\u000A 💲 Tiền nước: " . number_format($row['TienNuoc']) . " VND";
//                    if ($row4['GiaRac'] <> 0)
//                        $text .= "\u000A 💲 Tiền rác: " . number_format($row4['GiaRac']) . " VND";
//                    if ($row['TienMang'] <> 0)
//                        $text .= "\u000A 💲 Tiền mạng: " . number_format($row['TienMang']) . " VND";
//                    if ($row['TienXe'] <> 0)
//                        $text .= "\u000A 💲 Tiền xe: " . number_format($row['TienXe']) . " VND";
//                    if ($row['TienCPK'] <> 0)
//                        $text .= "\u000A 💲 " . $row['TenCPK'] . ": " . number_format($row['TienCPK']) . " VND";
//                    $text .= "\u000A 💲 Tổng tiền: " . number_format($row['TongTien']) . " VND";
//                } else $text = "✅ Chủ nhà của bạn chưa tính tiền phòng tháng " . $message_new[3] . "/" . $message_new[4] . ", vui lòng tra cứu sau.";
//            } else $text = "⚠ Sai mật khẩu hoặc không tìm thấy dữ liệu bạn cần.";
//        } else $text = "⚠ Bạn nhập sai cú pháp.\u000A" .
//            " 🔥 Vui lòng nhập đúng theo cú pháp\u000A ⚽ TRACUU <mã_phòng> <mật_khẩu> <tháng> <năm>,\u000A VD: TRACUU 123 123456 04 2017.";
    } elseif ($message_new[0] == "HELP") {
        $text = " 🔥 Các lệnh:" .
            "\u000A" .
            " ⚽ DANGKI <mã_phòng> <mật_khẩu>," .
            " để đăng kí nhận hóa đơn tiền phòng mỗi tháng.\u000A" .
            " VD: DANGKI 123 123456.\u000A" .

            " ⚽ TRACUU <mã_phòng> <mật_khẩu> <tháng> <năm>," .
            " để tra cứu tiền phòng theo tháng năm.\u000A" .
            " VD: TRACUU 123 123456 04 2017.\u000A" .

            " ⚽ XOA <mã_phòng>," .
            " để không nhận hóa đơn tiền phòng hàng tháng.\u000A" .
            " VD: XOA 123.\u000A" .

            " 🎲 HELP để xem các lệnh\u000A" .

            " 💜 ABOUT để xem thông tin tác giả.";

//    } elseif ($message_new[0] == "DANGKI") {
//        if (count($message_new) == 3) {
//            $sql3 = "SELECT * FROM phong WHERE id = '$message_new[1]' AND TienPhong = '$message_new[2]'";
//            $result3 = mysqli_query($conn, $sql3);
//
//            if (mysqli_num_rows($result3) > 0) {
//                $sql4 = "SELECT * FROM dangki WHERE idPhongNhan = '$message_new[1]' AND idFacebook = '$sender'";
//                $result4 = mysqli_query($conn, $sql4);
//
//                if (mysqli_num_rows($result4) > 0)
//                    $text = "⚠ Bạn đã đăng kí nhận hóa đơn hàng tháng cho phòng này rồi.";
//                else {
//                    $row3 = mysqli_fetch_array($result3);
//                    $iduser = $row3['idUser'];
//
//                    $sql = "INSERT INTO `dangki`(`id`, `idPhongNhan`, `idFacebook`, `idUser`, `MatKhau`) VALUES (NULL ,'$message_new[1]','$sender',$iduser,'$message_new[2]')";
//                    if ($result = mysqli_query($conn, $sql))
//                        $text = "✅ Bạn đã đăng kí nhận hóa đơn hàng tháng cho phòng " . $row3['PhongSo'] . " thành công. \u000A" .
//                            "✅ Chúng tôi sẽ gửi hóa đơn cho bạn khi có hóa đơn tiền phòng. \u000A" .
//                            " 🔥 Để không nhận hóa đơn nữa bạn có thể dùng cú pháp ⚽ XOA <mã_phòng>";
//                    else $text = "⚠ Có lỗi xảy ra vui lòng thử lại sau.";
//                }
//            } else $text = "⚠ Sai mật khẩu hoặc phòng không tồn tại.";
//        } else $text = "⚠ Bạn nhập sai cú pháp.\u000A" .
//            " 🔥 Vui lòng nhập đúng theo cú pháp\u000A 🎾 DANGKI <mã_phòng> <mật_khẩu> \u000A VD: DANGKI 123 123456.";
//    } elseif ($message_new[0] == "XOA") {
//        if (count($message_new) == 2) {
//            $sql3 = "SELECT * FROM dangki WHERE idPhongNhan = '$message_new[1]' AND idFacebook = '$sender'";
//            $result3 = mysqli_query($conn, $sql3);
//            if (mysqli_num_rows($result3) > 0) {
//                $sql4 = "DELETE FROM `dangki` WHERE idPhongNhan = '$message_new[1]' AND idFacebook = '$sender'";
//                if ($result4 = mysqli_query($conn, $sql4))
//                    $text = "✅ Hủy nhận hóa đơn hàng tháng thành công. \u000A" .
//                        " 🔥 Để đăng kí lại hóa đơn hàng tháng dùng cú pháp \u000A ⚽ DANGKI <mã_phòng> <mật_khẩu> \u000A VD: DANGKI 123 123456.";
//                else $text = "⚠ Có lỗi xảy ra vui lòng thử lại sau.";
//            } else $text = "⚠ Bạn không đăng kí phòng này hoặc phòng không tồn tại.";
//        } else $text = "⚠ Vui lòng nhập đúng theo cú pháp \u000A ⚽ XOA <mã_phòng> \u000A VD: XOA 123.";
//    } elseif ($message_new[0] == "ABOUT") {
//        $text = " ⚽ Phát triển bởi Nguyễn Văn Lộc.";
//    } elseif ($message_new[0] == "AHRI") {
//        $text = " 🎮 Bảng ngọc Ahri. \u000A" .
//                " ✅ Nhánh chính 🔥 Áp đảo \u000A" .
//                " ☑ Sốc điện \u000A" .
//                " ☑ Tác động bất chợt \u000A" .
//                " ☑ Mắt thấy ma \u000A" .
//                " ☑ Thợ săn tham lam \u000A" .
//                " ✅ Nhánh phụ ☔ Pháp thuật \u000A" .
//                " ☑ Thiêu rụi \u000A" .
//                " ☑ Mũ tối thượng";
    }
    else
        $text = " ⚽ Câu lệnh không hợp lệ.\u000A Gõ lệnh 🎲 HELP để xem các câu lệnh.";
    $jsonData2 = '{
                    "recipient":{
                            "id":"' . $sender . '"
                            },
                    "message":{
                            "text":"' . $text . '"
                            }
                    }';

    $ch2 = curl_init($url);
    curl_setopt($ch2, CURLOPT_POST, 1);
    curl_setopt($ch2, CURLOPT_POSTFIELDS, $jsonData2);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
    if (!empty($message)) {
        $result2 = curl_exec($ch2);
    }
    curl_close($ch2);
    header("HTTP/1.1 200 OK");
//    http_response_code(200);
}
?>