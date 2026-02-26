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
    <title>Create Blog | KoratSetGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap');

        body {
            font-family: 'Kanit', sans-serif;
            background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
            min-height: 100vh;
            color: #334e68;
        }

        .blog-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .page-title {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(90deg, #0077b6, #00b4d8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 35px;
            text-align: center;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #102a43;
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e1e8ed;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-label {
            font-weight: 500;
            color: #486581;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 18px;
            border: 2px solid #f0f4f8;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #00b4d8;
            box-shadow: 0 0 0 4px rgba(0, 180, 216, 0.15);
            background: #fff;
        }

        /* Custom File Upload UI */
        .upload-area {
            border: 2px dashed #bcccdc;
            padding: 30px;
            border-radius: 16px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: 0.3s;
        }

        .upload-area:hover {
            border-color: #00b4d8;
            background: #f0f9ff;
        }

        .image-preview {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .image-preview img {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            border-radius: 12px;
            border: 3px solid #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .save-btn {
            border-radius: 14px;
            padding: 16px;
            font-size: 18px;
            font-weight: 600;
            background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%);
            border: none;
            color: #fff;
            transition: all 0.4s ease;
            margin-top: 20px;
        }

        .save-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 119, 182, 0.3);
            color: #fff;
        }

        .input-group-text {
            background: #f0f4f8;
            border: 2px solid #f0f4f8;
            border-radius: 12px 0 0 12px;
            color: #627d98;
        }
    </style>
</head>

<body>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">

            <div class="blog-card">
                <div class="page-title">
                    <i class="fa-solid fa-pen-nib me-2"></i>Create Travel Blog
                </div>

                <form action="save_blog.php" method="post" enctype="multipart/form-data">

                    <div class="mb-5">
                        <div class="section-title">
                            <i class="fa-solid fa-file-lines text-primary"></i> Blog Content
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Blog Title</label>
                            <input type="text" name="title" class="form-control" placeholder="เช่น ทริปสั้นๆ ณ เขาใหญ่ 2 วัน 1 คืน" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="content" rows="6" class="form-control" placeholder="เล่าเรื่องราวความประทับใจของคุณ..." required></textarea>
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="section-title">
                            <i class="fa-solid fa-images text-primary"></i> Blog Images
                        </div>

                        <label for="images" class="upload-area w-100" id="drop-zone">
                            <i class="fa-solid fa-cloud-arrow-up fa-3x mb-3 text-primary"></i>
                            <p class="mb-1 fw-bold">Click to upload or drag and drop</p>
                            <p class="text-muted small">PNG, JPG or JPEG (Max. 10 files)</p>
                            <input type="file" name="images[]" id="images" class="d-none" accept="image/*" multiple required>
                        </label>

                        <div id="preview" class="image-preview"></div>
                        <small class="text-muted d-block mt-2">
                             <i class="fa-solid fa-circle-info me-1"></i> รูปแรกจะถูกใช้เป็นภาพหน้าปก (Cover)
                        </small>
                    </div>

                    <div class="mb-5">
                        <div class="section-title">
                            <i class="fa-solid fa-circle-info text-primary"></i> Travel Details
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Vehicle Type</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-car"></i></span>
                                    <input type="text" name="type_car" class="form-control" placeholder="เช่น รถส่วนตัว">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Budget (฿)</label>
                                <div class="input-group">
                                    <span class="input-group-text">฿</span>
                                    <input type="number" name="total_cost" class="form-control" placeholder="0.00">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Duration (Days)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-calendar-day"></i></span>
                                    <input type="number" name="trip_days" class="form-control" placeholder="จำนวนวัน">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Travelers</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-users"></i></span>
                                    <input type="number" name="traveler_count" class="form-control" placeholder="กี่คน">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="section-title">
                            <i class="fa-solid fa-hashtag text-primary"></i> Hashtags
                        </div>
                        <input type="text" name="hashtags" class="form-control" placeholder="#เที่ยวโคราช #คาเฟ่ #nature" required>
                        <small class="text-muted">แยกแต่ละแท็กด้วยการเว้นวรรค</small>
                    </div>

                    <button type="submit" class="save-btn w-100">
                        <i class="fa-solid fa-paper-plane me-2"></i> Publish Blog Post
                    </button>

                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Improved Image Preview
    document.getElementById('images').addEventListener('change', function(){
        const preview = document.getElementById('preview');
        preview.innerHTML = '';
        
        if (this.files.length > 0) {
            [...this.files].forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const div = document.createElement('div');
                    div.innerHTML = `<img src="${e.target.result}" class="img-fluid">`;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }
    });

    // Optional: Add simple Drag & Drop visual effect
    const dropZone = document.getElementById('drop-zone');
    ['dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, e => {
            e.preventDefault();
            if(eventName === 'dragover') dropZone.style.borderColor = '#00b4d8';
            else dropZone.style.borderColor = '#bcccdc';
        });
    });
</script>

</body>
</html>