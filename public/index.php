<?php
require __DIR__.'/../vendor/autoload.php';

use App\MessageService;
use Carbon\Carbon;

$messageService = new MessageService(__DIR__.'/../messages.json');

if (! empty($_GET['m'])) {
    if (filter_var($_GET['m'], FILTER_VALIDATE_INT) === false) {
        header('Location: /');
        exit;
    }

    if (empty($message = $messageService->getMessage($_GET['m']))) {
        header('Location: /');
        exit;
    }
}

if (empty($message)) {
    $message = $messageService->getRandomMessage();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Scott will know!</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <link rel="icon" type="image/x-icon" href="profile.png">
        <style type="text/css">
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
            }

            @font-face {
                font-family: 'OpenSans';
                src: url('OpenSans-Regular.ttf');
            }

            p, a {
                font-family: 'OpenSans';
                font-weight: 400;
            }

            div.container {
                height: 100%;
                max-width: 80rem;
                margin: auto;
                display: flex;
                flex-direction: column;
            }

            div.message-container {
                margin: auto;
                padding: 0 20px;
                .row {
                    display: flex;
                    column-gap: 8px;
                }
            }

            div.name {
                color: rgb(97, 97, 97);
                margin-left: 40px;
                p {
                    font-size: 12px;
                    margin: 0;
                }
            }

            div.time {
                color: rgb(97, 97, 97);
                p {
                    font-size: 12px;
                    margin: 0;
                }
            }

            div.image {
                height: 32px;
                width: 32px;
                background-color: white;
                background-image: url('profile.png');
                background-size: cover;
                margin-top: 2px;
                border-radius: 10000px;
                flex-shrink: 0;
            }

            div.message {
                background-color: rgb(245, 245, 245);
                border-radius: 6px;
                color: rgb(36, 36, 36);
                padding: 6px 15px 8px;
                max-width: 570px;
                p {
                    font-size: 14px;
                    padding: 2px;
                    margin: 0;
                    img {
                        max-width: 100%;
                    }
                }
            }

            div.links {
                display: flex;
                div {
                    flex: 0 50%;
                    padding: 10px;
                    a {
                        font-size: 14px;
                        color: rgb(97, 97, 97);
                        text-decoration: none;
                    }
                    &.share {
                        text-align: left;
                    }
                    &.github {
                        text-align: right;
                    }
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="message-container">
                <div class="row">
                    <div class="name">
                        <p>Scott Dutton</p>
                    </div>
                    <div class="time">
                        <p><?= Carbon::now()->format('H:i'); ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="image"></div>
                    <div class="message">
                        <p><?= $message->isImage() ? "<img src='".$message->body."' />" : $message->body ?></p>
                    </div>
                </div>
            </div>
            <div class="links">
                <div class="share">
                    <a href="https://www.askdutton.co.uk/?m=<?= $message->index ?>">Share this message</a>
                </div>
                <div class="github">
                    <a href="https://github.com/phleech/askdutton">Got a better response?</a>
                </div>
            </div>
        </div>
    </body>
</html>
