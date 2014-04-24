<!DOCTYPE html>
<html>
    <body style="background:#ccc;">

        <div id="container" style="width:100%;height:auto; background:#fff;box-shadow:0px 0px 35px #1D1D1D;display:block;">
            <div id="header" style="background:#F80; color:#fff; padding:20px; font-size:18px;text-align:center; font-family:sans-serif;">
                ZongList
            </div>
            <div id="content" style="background:#EBEBE0; color:#000;font-size:14px;font-family:sans-serif;padding:20px;">
                     Your accont at <b>ZongList</b> has been created!
                     <br />
                     Here are your credentials:
                     <br /><br />
                     Username: <b><?php print $username; ?></b>
                     <br /><br />
                     Password: <b><?php print $password; ?></b>
                     <br /><br />
                     <b>If you use your account you implicitly agree with the terms of use</b>
                     <br />
                     <a href="http://beta.zonglist.com/terms-of-use">http://beta.zonglist.com/terms-of-use</a>
            </div>
            <div id="footer" style="background:#BCBCB2; color:#000;font-size:14px;font-family:sans-serif;padding:20px;height:35px;">
                <div style="width:49%; float:left !important; line-height:20px; font-size:13px;">
                    Copyright &copy; 2014. ZongList
                    <br />
                    All rights reserved.
                    <br /><br /><br />
                </div>
                <div style="width:49%; float:right !important; text-align:right; line-height:20px; font-size:13px;">
                    For any problems regarding <a href="http://www.zonglist.com" style="color:#900; text-decoration:none;">ZongList</a> <br />
                    feel free to email us at <a href="mailto:support@zonglist.com" style="color:#900;text-decoration:none;">support@zonglist.com</a>.
                    <br /><br /><br />
                </div>
            </div>
        </div>

    </body>
</html>