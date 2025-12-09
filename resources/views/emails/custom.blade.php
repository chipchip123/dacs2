<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        .box {
            padding: 20px;
            background: #f6f6f6;
            border-radius: 8px;
            font-family: Arial;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .content {
            font-size: 15px;
            line-height: 1.5;
            background: white;
            padding: 15px;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="title">📩 Thông báo từ ChipFood</div>

        <div class="content">
            {!! nl2br(e($messageText)) !!}
        </div>

        <p style="margin-top:20px;">Trân trọng,<br>ChipFood Team</p>
    </div>
</body>
</html>
