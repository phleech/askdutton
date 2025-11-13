<?php
require __DIR__.'/../vendor/autoload.php';

use App\MessageService;
use Carbon\Carbon;

$messageService = new MessageService(__DIR__.'/../messages.json');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Scott will know!</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <link rel="icon" type="image/x-icon" href="profile.png">
        <style>
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
                }
            }

            div.github {
                text-align: right;
                padding: 10px;
                a {
                    font-size: 14px;
                    color: rgb(97, 97, 97);
                    text-decoration: none;
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
                        <p><?= $messageService->getMessage(); ?></p>
                    </div>
                </div>
            </div>
            <div class="github">
                <a href="https://github.com/phleech/askdutton">Got a better response?</a>
            </div>
        </div>
    </body>
</html>
