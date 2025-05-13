document.addEventListener('DOMContentLoaded', function() {
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('image-upload');
    const previewArea = document.getElementById('preview-area');

    // クリックでファイル選択をトリガー
    dropArea.addEventListener('click', function() {
        fileInput.click();
    });

    // ファイルが選択された時の処理（クリックまたはドロップ）
    const handleFiles = (files) => {
        for (const file of files) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    previewArea.appendChild(img);
                };
                reader.readAsDataURL(file);
            } else {
                alert('画像ファイルを選択してください。');
                fileInput.value = ''; // 選択をリセット
                previewArea.innerHTML = ''; // プレビューをクリア
                break; // 画像以外のファイルが混ざっていた場合は処理を中断
            }
        }
    };

    // ドロップ時の処理
    dropArea.addEventListener('drop', function (e) {
        console.log('drop イベント発生');
    
        e.preventDefault();
        dropArea.classList.remove('dragover');
        previewArea.innerHTML = ''; // 既存のプレビューをクリア
        handleFiles(e.dataTransfer.files);
    });

    // ドラッグオーバー時のスタイル変更
    dropArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        console.log('dragover イベント発生');
        dropArea.classList.add('dragover');
    });

    // ドラッグリーブ時のスタイルを戻す
    dropArea.addEventListener('dragleave', function(e) {
        dropArea.classList.remove('dragover');
    });

    // input[type="file"] が変更された時の処理（クリック選択）
    fileInput.addEventListener('change', function() {
        previewArea.innerHTML = ''; // 既存のプレビューをクリア
        handleFiles(this.files);
    });
});