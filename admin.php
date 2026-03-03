<?php
require 'db.php';

// --- DELETE LOGIC ---
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM projects WHERE id = ?")->execute([$_GET['delete']]);
    header("Location: admin.php");
    exit;
}

// --- SAVE / UPDATE LOGIC ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image_path = $_POST['existing_image'] ?? '';

    if (isset($_FILES['project_file']) && $_FILES['project_file']['error'] == 0) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $file_name = time() . '_' . basename($_FILES['project_file']['name']);
        $target_file = $upload_dir . $file_name;
        if (move_uploaded_file($_FILES['project_file']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        }
    }

    $data = [$_POST['title'], $_POST['cat'], $_POST['short'], $_POST['long'], $_POST['p_link'], $_POST['l_type'], $image_path];

    if (!empty($_POST['id'])) {
        $sql = "UPDATE projects SET title=?, category=?, short_desc=?, long_desc=?, project_link=?, link_type=?, image_url=? WHERE id=?";
        $data[] = $_POST['id'];
    } else {
        $sql = "INSERT INTO projects (title, category, short_desc, long_desc, project_link, link_type, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)";
    }
    $pdo->prepare($sql)->execute($data);
    header("Location: admin.php");
    exit;
}

$projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll();
$edit_p = isset($_GET['edit']) ? $pdo->query("SELECT * FROM projects WHERE id=" . (int)$_GET['edit'])->fetch() : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Studio Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-[#f8f9fb] text-[#1a1a1a]">

    <div class="flex flex-col lg:flex-row min-h-screen">

        <aside class="lg:w-[450px] bg-white p-8 lg:h-screen lg:sticky lg:top-0 border-r border-gray-100 overflow-y-auto custom-scrollbar">
            <div class="mb-10 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-800 tracking-tighter">Studio Dashboard</h1>
                    <p class="text-xs opacity-40 font-bold uppercase tracking-widest mt-1">Manage Portfolio</p>
                </div>
                <a href="index.php" class="text-[10px] bg-gray-100 px-3 py-1 rounded-full font-bold hover:bg-black hover:text-white transition-all">VIEW SITE</a>
            </div>

            <form method="POST" enctype="multipart/form-data" class="space-y-5">
                <input type="hidden" name="id" value="<?= $edit_p['id'] ?? '' ?>">
                <input type="hidden" name="existing_image" value="<?= $edit_p['image_url'] ?? '' ?>">

                <div>
                    <label class="text-[10px] font-bold uppercase opacity-40 ml-1">Project Identity</label>
                    <input type="text" name="title" value="<?= $edit_p['title'] ?? '' ?>" placeholder="Title" class="w-full mt-1.5 p-4 bg-gray-50 rounded-2xl border-2 border-transparent focus:border-blue-500 focus:bg-white outline-none transition-all" required>
                    <input type="text" name="cat" value="<?= $edit_p['category'] ?? '' ?>" placeholder="Category (e.g., UI/UX, Logo)" class="w-full mt-2 p-4 bg-gray-50 rounded-2xl border-2 border-transparent focus:border-blue-500 focus:bg-white outline-none transition-all">
                </div>

                <div>
                    <label class="text-[10px] font-bold uppercase opacity-40 ml-1">Media Asset</label>
                    <div class="relative mt-1.5 group">
                        <input type="file" name="project_file" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                        <div class="p-8 border-2 border-dashed border-gray-200 rounded-2xl text-center group-hover:border-blue-400 transition-colors bg-gray-50">
                            <span class="text-2xl">🖼️</span>
                            <p class="text-xs font-bold opacity-40 mt-2">Upload image from computer</p>
                        </div>
                    </div>
                    <?php if ($edit_p && $edit_p['image_url']): ?>
                        <p class="text-[10px] mt-2 italic text-blue-500">Current: <?= basename($edit_p['image_url']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="text-[10px] font-bold uppercase opacity-40 ml-1">Action Link</label>
                    <div class="flex gap-2 mt-1.5">
                        <select name="l_type" class="p-4 bg-gray-50 rounded-2xl text-sm font-semibold outline-none border-2 border-transparent focus:border-blue-500">
                            <option value="Live Website" <?= ($edit_p['link_type'] ?? '') == 'Live Website' ? 'selected' : '' ?>>Web</option>
                            <option value="GitHub Repo" <?= ($edit_p['link_type'] ?? '') == 'GitHub Repo' ? 'selected' : '' ?>>Git</option>
                            <option value="Figma Design" <?= ($edit_p['link_type'] ?? '') == 'Figma Design' ? 'selected' : '' ?>>Figma</option>
                            <option value="View Poster" <?= ($edit_p['link_type'] ?? '') == 'View Poster' ? 'selected' : '' ?>>Poster</option>
                        </select>
                        <input type="url" name="p_link" value="<?= $edit_p['project_link'] ?? '' ?>" placeholder="https://..." class="flex-1 p-4 bg-gray-50 rounded-2xl outline-none border-2 border-transparent focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-bold uppercase opacity-40 ml-1">Content</label>
                    <textarea name="short" placeholder="Catchy one-liner..." class="w-full mt-1.5 p-4 bg-gray-50 rounded-2xl outline-none border-2 border-transparent focus:border-blue-500 h-20"><?= $edit_p['short_desc'] ?? '' ?></textarea>
                    <textarea name="long" placeholder="The full case study story..." class="w-full mt-2 p-4 bg-gray-50 rounded-2xl outline-none border-2 border-transparent focus:border-blue-500 h-40"><?= $edit_p['long_desc'] ?? '' ?></textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white p-5 rounded-2xl font-800 uppercase tracking-widest hover:bg-black transition-all shadow-lg shadow-blue-100">
                    <?= $edit_p ? 'Update Project' : 'Publish Project' ?>
                </button>

                <?php if ($edit_p): ?>
                    <a href="admin.php" class="block text-center text-xs font-bold opacity-30 hover:opacity-100 mt-2">Cancel Editing</a>
                <?php endif; ?>
            </form>
        </aside>

        <main class="flex-1 p-8 lg:p-12">
            <div class="max-w-5xl mx-auto">
                <header class="mb-12">
                    <h2 class="text-4xl font-800 tracking-tight italic">Live Collection</h2>
                    <p class="opacity-40 text-sm mt-1">You have <?= count($projects) ?> projects published.</p>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                    <?php foreach ($projects as $p): ?>
                        <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-xl transition-all border border-gray-100 group">
                            <div class="h-48 overflow-hidden relative">
                                <img src="<?= $p['image_url'] ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute top-4 left-4">
                                    <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider shadow-sm">
                                        <?= $p['category'] ?>
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="font-800 text-lg leading-tight mb-2"><?= $p['title'] ?></h3>
                                <div class="flex gap-4 pt-4 border-t border-gray-50 mt-4">
                                    <a href="admin.php?edit=<?= $p['id'] ?>" class="text-[10px] font-bold text-blue-600 uppercase tracking-widest hover:underline">Edit</a>
                                    <a href="admin.php?delete=<?= $p['id'] ?>" onclick="return confirm('Archive this project?')" class="text-[10px] font-bold text-red-400 uppercase tracking-widest hover:underline">Delete</a>
                                    <a href="projectdetail.php?id=<?= $p['id'] ?>" target="_blank" class="ml-auto text-[10px] font-bold opacity-30 uppercase tracking-widest hover:opacity-100">Live ↗</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>

</body>

</html>