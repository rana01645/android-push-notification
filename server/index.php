<html>
    <head>
        <title>AndroidRace| Firebase Cloud Messaging</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="//www.gstatic.com/mobilesdk/160503_mobilesdk/logo/favicon.ico">
        <link rel="stylesheet" href="style.css">

        <style type="text/css">
            body{
            }
            div.container{
                width: 1000px;
                margin: 0 auto;
                position: relative;
            }
            legend{
                font-size: 30px;
                color: #555;
            }
            .btn_send{
                background: #00bcd4;
            }
            label{
                margin:10px 0px !important;
            }
            textarea{
                resize: none !important;
            }
            .fl_window{
                width: 400px;
                position: absolute;
                right: 0;
                top:100px;
            }
            pre, code {
                padding:10px 0px;
                box-sizing:border-box;
                -moz-box-sizing:border-box;
                webkit-box-sizing:border-box;
                display:block; 
                white-space: pre-wrap;  
                white-space: -moz-pre-wrap; 
                white-space: -pre-wrap; 
                white-space: -o-pre-wrap; 
                word-wrap: break-word; 
                width:100%; overflow-x:auto;
            }

        </style>
    </head>
    <body>
        <?php
        // Enabling error reporting
        error_reporting(-1);
        ini_set('display_errors', 'On');

        require_once __DIR__ . '/firebase.php';
        require_once __DIR__ . '/push.php';

        $firebase = new Firebase();
        $push = new Push();

        // optional payload
        $payload = array();
        $payload['Website:'] = 'Androidrace.com';
        $payload['Category'] = 'Android dev';

		

		
        // notification title
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        
        // notification message
        $message = isset($_GET['message']) ? $_GET['message'] : '';
        
        // push type - single user / topic
        $push_type = isset($_GET['push_type']) ? $_GET['push_type'] : '';
        
        // whether to include to image or not
        $include_image = isset($_GET['include_image']) ? TRUE : FALSE;
		
				// server key
        $img = isset($_GET['img']) ? $_GET['img'] : '';


        $push->setTitle($title);
        $push->setMessage($message);
        if ($include_image) {
            $push->setImage($img);
        } else {
            $push->setImage('');
        }
        $push->setPayload($payload);


        $json = '';
        $response = '';

        if ($push_type == 'topic') {
            $json = $push->getPush();
            $response = $firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $push->getPush();
            $regId = isset($_GET['regId']) ? $_GET['regId'] : '';
            $response = $firebase->send($regId, $json);
        }
        ?>
        <div class="container">
            <div class="fl_window">
                <div><h1>AndroidRace</h1></div>
                <br/>
                <?php if ($json != '') { ?>
                    <label><b>Request:</b></label>
                    <div class="json_preview">
					
                        <pre><?php echo json_encode($json) ?></pre>
                    </div>
                <?php } ?>
                <br/>
                <?php if ($response != '') { ?>
                    <label><b>Response:</b></label>
                    <div class="json_preview">
                        <pre><?php echo json_encode($response) ?></pre>
                    </div>
                <?php } ?>

            </div>

          
          
            <br/><br/><br/><br/>

            <form class="pure-form pure-form-stacked" method="get">
                <fieldset>
                    <legend>Send to Topic `global`</legend>

                    <label for="title1">Title</label>
                    <input type="text" id="title1" name="title" class="pure-input-1-2" placeholder="Enter title">

                    <label for="message1">Message</label>
                    <textarea class="pure-input-1-2" name="message" id="message1" rows="5" placeholder="Notification message!"></textarea>

                    <label for="include_image1" class="pure-checkbox">
                        <input id="include_image1" name="include_image" type="checkbox"> Include image
                    </label>
					
					<label for="img1">Image Url</label>
                    <textarea class="pure-input-1-2" name="img" id="img1" rows="5" placeholder="Imagee url !"></textarea>
                    <input type="hidden" name="push_type" value="topic"/>
                    <button type="submit" class="pure-button pure-button-primary btn_send">Send to Topic</button>
                </fieldset>
            </form>
        </div>
    </body>
</html>
