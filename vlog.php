<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: signin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Vlog | KoratSetGo</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap');

        body {
            background: #0f1113; /* Deep dark gray */
            background-image: radial-gradient(circle at 50% -20%, #2c3e50 0%, #000000 80%);
            color: #e1e1e1;
            font-family: 'Kanit', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .vlog-card {
            max-width: 700px;
            margin: 40px auto;
            background: rgba(25, 25, 25, 0.8);
            backdrop-filter: blur(15px);
            border-radius: 30px;
            padding: 50px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
        }

        .header-section i {
            font-size: 3rem;
            color: #ff3d3d;
            margin-bottom: 15px;
            filter: drop-shadow(0 0 10px rgba(255, 61, 61, 0.4));
        }

        /* Form Styling */
        .form-label {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 8px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 12px 18px;
            color: #fff;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.07);
            border-color: #ff3d3d;
            box-shadow: 0 0 0 3px rgba(255, 61, 61, 0.15);
            color: #fff;
        }

        /* Custom Upload Zone */
        .upload-zone {
            position: relative;
            border: 2px dashed rgba(255, 61, 61, 0.3);
            border-radius: 20px;
            padding: 40px 20px;
            text-align: center;
            transition: 0.3s;
            background: rgba(255, 61, 61, 0.02);
            cursor: pointer;
        }

        .upload-zone:hover {
            border-color: #ff3d3d;
            background: rgba(255, 61, 61, 0.05);
        }

        .upload-zone i {
            font-size: 2.5rem;
            color: #ff3d3d;
            margin-bottom: 10px;
        }

        /* Buttons */
        .upload-btn {
            background: linear-gradient(135deg, #ff3d3d, #c02424);
            border: none;
            padding: 16px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 15px;
            color: #fff;
            box-shadow: 0 10px 20px rgba(255, 61, 61, 0.2);
            transition: 0.4s ease;
        }

        .upload-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(255, 61, 61, 0.4);
            filter: brightness(1.1);
        }

        /* Input Group Icon */
        .input-group-text {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ff3d3d;
            border-radius: 12px 0 0 12px;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="vlog-card">
        <div class="header-section text-center mb-5">
            <i class="fa-solid fa-clapperboard"></i>
            <h2 class="fw-bold">Upload Your Vlog</h2>
            <p class="text-muted">แบ่งปันเรื่องราวการเดินทางของคุณให้โลกได้เห็น</p>
        </div>

        <form action="save_vlog.php" method="POST" enctype="multipart/form-data">

            <div class="mb-4">
                <label class="form-label">Video File</label>
                <div class="upload-zone" onclick="document.getElementById('video-input').click()">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <h5 class="mb-1">Click to select video</h5>
                    <p class="text-muted small mb-0">MP4, MOV or AVI (Max 500MB)</p>
                    <input type="file" name="video" id="video-input" class="d-none" accept="video/*" required>
                    <div id="file-name" class="mt-2 text-info small fw-bold"></div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label class="form-label">Vlog Title</label>
                    <input type="text" name="title" class="form-control" placeholder="ชื่อคลิปที่น่าดึงดูด..." required>
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="content" rows="3" class="form-control" placeholder="เล่าเรื่องย่อๆ ของทริปนี้..."></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Budget (฿)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-baht-sign"></i></span>
                        <input type="number" name="total_cost" class="form-control" placeholder="เช่น 3500">
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Hashtags</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                        <input type="text" name="hashtags" class="form-control" placeholder="vlog, travel, korat" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="upload-btn w-100 mt-2">
                <i class="fa-solid fa-paper-plane me-2"></i> Publish Vlog Now
            </button>
        </form>
    </div>
</div>

<script>
    // แสดงชื่อไฟล์เมื่อเลือกวิดีโอสำเร็จ
    document.getElementById('video-input').addEventListener('change', function(e) {
        let fileName = e.target.files[0].name;
        document.getElementById('file-name').innerHTML = '<i class="fa-solid fa-file-video me-1"></i> Selected: ' + fileName;
    });
</script>

</body>
</html>