<?php
require 'db.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();
if (!$p) die("Project not found");

// Fetch ALL other projects for the horizontal scroll
$stmt_others = $pdo->prepare("SELECT * FROM projects WHERE id != ? ORDER BY created_at DESC");
$stmt_others->execute([$id]);
$other_projects = $stmt_others->fetchAll();
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,900&family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .display-font {
            font-family: 'Playfair Display', serif;
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-[#fdfdfb] text-[#1a1a1a] antialiased">
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/60 backdrop-blur-lg border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-8 py-4 flex justify-between items-center">
            <a href="index.php" class="text-[10px] font-bold uppercase tracking-widest opacity-50 hover:opacity-100 transition-all flex items-center gap-2">
                <span>←</span> Back
            </a>
            <div class="text-[9px] font-black uppercase tracking-[0.3em] text-blue-600"><?= htmlspecialchars($p['category']) ?></div>
        </div>
    </nav>

    <main class="pt-32 pb-20">
        <div class="max-w-4xl mx-auto px-6">
            <header class="text-center mb-16">
                <h1 class="text-5xl md:text-7xl display-font italic font-black mb-8 leading-tight tracking-tight"><?= htmlspecialchars($p['title']) ?></h1>
                <p class="max-w-xl mx-auto text-sm text-gray-400 leading-relaxed italic border-l-2 border-blue-600 pl-4"><?= htmlspecialchars($p['short_desc']) ?></p>
            </header>

            <div class="flex justify-center mb-24">
                <div class="w-full max-w-sm aspect-[3/4] rounded-[2.5rem] overflow-hidden shadow-2xl border-[12px] border-white bg-white">
                    <img src="<?= htmlspecialchars($p['image_url']) ?>" class="w-full h-full object-cover" alt="Hero">
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-12 mb-32 border-t border-gray-50 pt-16">
                <div class="md:col-span-1">
                    <h3 class="text-[10px] font-bold uppercase opacity-20 mb-6 tracking-widest italic">The Brief</h3>
                    <?php if ($p['project_link']): ?>
                        <a href="<?= $p['project_link'] ?>" target="_blank" class="inline-flex items-center gap-2 bg-black text-white px-6 py-3 rounded-full text-[9px] font-bold uppercase tracking-widest hover:bg-blue-600 transition-all">
                            Open <?= $p['link_type'] ?> ↗
                        </a>
                    <?php endif; ?>
                </div>
                <div class="md:col-span-2">
                    <div class="text-lg leading-relaxed text-gray-800 whitespace-pre-wrap font-medium">
                        <?= nl2br(htmlspecialchars($p['long_desc'])) ?>
                    </div>
                </div>
            </div>
        </div>

        <section class="mt-20 border-t border-gray-100 pt-20 bg-gray-50/50 pb-20">
            <div class="max-w-7xl mx-auto px-8 flex justify-between items-end mb-10">
                <div>
                    <h2 class="display-font text-4xl italic font-black">Explore Works</h2>
                    <p class="text-[10px] font-bold uppercase opacity-30 tracking-widest mt-2">Swipe horizontally to see all projects</p>
                </div>
                <div class="flex gap-2">
                    <div class="w-8 h-[2px] bg-blue-600"></div>
                    <div class="w-4 h-[2px] bg-gray-200"></div>
                </div>
            </div>

            <div class="flex overflow-x-auto no-scrollbar snap-x snap-mandatory gap-8 px-8 lg:px-[calc((100vw-1200px)/2)]">
                <?php foreach ($other_projects as $other): ?>
                    <a href="projectdetail.php?id=<?= $other['id'] ?>" class="snap-start flex-none group w-[280px]">
                        <div class="aspect-[3/4] rounded-[2rem] overflow-hidden bg-white shadow-md group-hover:shadow-2xl group-hover:-translate-y-2 transition-all duration-500 border border-gray-100">
                            <img src="<?= htmlspecialchars($other['image_url']) ?>"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        </div>
                        <div class="mt-6 px-2">
                            <span class="text-[9px] font-black uppercase tracking-[0.2em] text-blue-600 block mb-1"><?= htmlspecialchars($other['category']) ?></span>
                            <h4 class="display-font text-xl italic font-black group-hover:text-blue-600 transition-colors"><?= htmlspecialchars($other['title']) ?></h4>
                        </div>
                    </a>
                <?php endforeach; ?>

                <div class="flex-none w-20"></div>
            </div>
        </section>
    </main>

    <footer class="py-12 text-center border-t border-gray-50 bg-white">
        <p class="text-[9px] font-bold opacity-20 uppercase tracking-[0.4em]">© 2026 Portfolio / Norton</p>
    </footer>
</body>

</html>