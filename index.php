<?php
// 1. Include your database connection
require 'db.php';

// 2. Fetch projects from the database
try {
    $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
    $db_projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $db_projects = []; // Fallback to empty if DB fails
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Designer Portfolio | 2026 Refined</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Playfair Display', 'serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#1d63ed',
                        secondary: '#b8e14b',
                        accent: '#f26444',
                        bgSoft: '#fdfdfb',
                        dark: '#1a1a1a',
                    }
                }
            }
        }
    </script>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-15px) rotate(2deg);
            }
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        @keyframes twinkle {

            0%,
            100% {
                opacity: 0.3;
                transform: scale(0.8);
            }

            50% {
                opacity: 1;
                transform: scale(1.2);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-marquee {
            animation: marquee 50s linear infinite;
        }

        /* Stops scrolling when mouse is over or dragging */
        .marquee-container:hover .animate-marquee,
        .marquee-container.active .animate-marquee {
            animation-play-state: paused;
        }

        .animate-twinkle {
            animation: twinkle 3s ease-in-out infinite;
        }

        .shape-blob {
            position: absolute;
            filter: blur(40px);
            z-index: 0;
            opacity: 0.15;
            border-radius: 50%;
        }

        /* Manual Scroll Utilities */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .cursor-grab {
            cursor: grab;
        }

        .cursor-grabbing {
            cursor: grabbing;
        }
    </style>
</head>

<body class="bg-bgSoft text-dark font-body antialiased">

    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/70 backdrop-blur-xl border-b border-gray-100">
        <div class="flex justify-between items-center px-8 md:px-12 py-4 max-w-7xl mx-auto">
            <div class="font-display text-xl font-black tracking-tight">Portfolio</div>
            <div class="hidden md:flex gap-8 text-[11px] font-bold opacity-50 uppercase tracking-[0.2em]">
                <a href="#about" class="hover:text-primary transition-colors hover:opacity-100">About</a>
                <a href="#projects" class="hover:text-primary transition-colors hover:opacity-100">Projects</a>
                <a href="#contact" class="hover:text-primary transition-colors hover:opacity-100">Contact</a>
            </div>
        </div>
    </nav>

    <section class="relative min-h-screen flex items-center px-6 md:px-12 pt-16 overflow-hidden">
        <div class="shape-blob w-64 h-64 bg-primary top-20 -left-20"></div>
        <div class="shape-blob w-80 h-80 bg-secondary bottom-10 -right-20"></div>
        <div class="absolute top-1/4 right-1/4 text-primary animate-twinkle text-4xl">✦</div>
        <div class="absolute bottom-1/3 left-10 text-accent animate-twinkle delay-700 text-2xl">✦</div>

        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-16 items-center w-full relative z-10">
            <div class="relative">
                <p class="text-[10px] font-bold tracking-[0.3em] uppercase opacity-40 mb-4">UI/UX Design Student</p>
                <h1 class="font-display text-7xl md:text-8xl lg:text-9xl leading-[0.85] font-black text-dark mb-8">
                    Port<br><span class="text-primary italic">folio</span>
                </h1>

                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="bg-accent text-white px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider">UI/UX Designer</span>
                    <span class="bg-secondary text-dark px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider">2026 Edition</span>
                </div>

                <p class="max-w-xs text-sm text-dark/50 leading-relaxed mb-8">
                    Exploring the intersection of user experience, interface design, and creative problem-solving.
                </p>

                <div class="flex items-center gap-6">
                    <a href="#projects" class="bg-primary text-white px-6 py-3.5 rounded-full text-xs font-bold hover:shadow-xl hover:-translate-y-1 transition-all">
                        View Projects ↓
                    </a>
                    <a href="#contact" class="text-xs font-bold border-b border-dark/20 pb-1 hover:border-dark transition-colors">Say Hello</a>
                </div>
            </div>
            <div class="relative flex justify-center">
                <div class="absolute -inset-10 bg-secondary/10 rounded-full blur-3xl"></div>
                <div class="relative w-72 h-[24rem] bg-white rounded-2xl shadow-xl p-3 border border-gray-100 animate-float">
                    <div class="absolute -top-4 -right-4 bg-accent text-white p-2 rounded-full shadow-lg text-xs animate-twinkle">✦</div>
                    <div class="w-full h-[18rem] bg-slate-100 rounded-xl overflow-hidden border border-gray-50">
                        <?php if (file_exists('uploads/profile.png')): ?>
                            <img src="uploads/profile.png" alt="Profile" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-slate-300 italic text-xs">No Profile Image</div>
                        <?php endif; ?>
                    </div>
                    <div class="mt-5 px-3">
                        <div class="flex justify-between items-center mb-4">
                            <div class="h-2 w-20 bg-primary/20 rounded-full"></div>
                            <div class="h-2 w-8 bg-secondary rounded-full"></div>
                        </div>
                        <div class="h-1.5 w-full bg-slate-100 rounded-full mb-2"></div>
                        <div class="h-1.5 w-3/4 bg-slate-100 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="relative py-24 px-6 bg-white overflow-hidden">
        <div class="shape-blob w-96 h-96 bg-accent/5 -bottom-20 -left-20"></div>
        <div class="absolute top-20 right-20 text-secondary animate-twinkle text-5xl">✦</div>

        <div class="max-w-5xl mx-auto grid md:grid-cols-2 gap-16 items-center relative z-10">
            <div class="relative">
                <div class="absolute -top-6 -left-6 w-12 h-12 bg-secondary rounded-full opacity-20 animate-float"></div>
                <div class="relative aspect-[4/5] max-w-xs mx-auto bg-slate-50 shadow-sm rounded-xl border border-gray-100 overflow-hidden group">
                    <?php if (file_exists('uploads/image.png')): ?>
                        <img src="uploads/image.png" alt="About Me" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <?php else: ?>
                        <div class="absolute inset-0 flex items-center justify-center opacity-20 italic text-xs">Image Placeholder</div>
                    <?php endif; ?>
                    <div class="absolute inset-0 shadow-[inset_0_0_40px_rgba(0,0,0,0.05)] pointer-events-none"></div>
                </div>
            </div>
            <div class="order-1 md:order-2">
                <h2 class="font-display text-7xl font-black mb-8 relative">
                    Hello!
                    <span class="absolute -top-4 -right-8 text-primary animate-twinkle">✦</span>
                </h2>
                <p class="text-lg text-dark/70 leading-relaxed mb-8">
                    I'm a <span class="font-bold text-dark italic">UI/UX design student</span> passionate about creating intuitive and beautiful digital experiences.
                </p>
                <div class="flex flex-wrap gap-3">
                    <?php
                    $tags = ["UI Design", "UX Research", "Wireframing", "Prototyping", "Figma"];
                    foreach ($tags as $tag): ?>
                        <span class="bg-secondary text-dark px-4 py-1.5 rounded-full text-xs font-bold hover:scale-105 transition-transform cursor-default"><?= $tag ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section id="projects" class="relative py-24 overflow-hidden">
        <div class="absolute top-10 left-1/2 text-primary opacity-20 text-6xl pointer-events-none">✦</div>

        <div class="max-w-6xl mx-auto px-6 mb-12">
            <h2 class="font-display text-4xl font-black mb-2">Project Highlights</h2>
            <p class="text-xs opacity-40 uppercase tracking-widest">Selected Works (Drag to scroll)</p>
        </div>

        <div class="marquee-container overflow-x-auto no-scrollbar px-6 cursor-grab active:cursor-grabbing" id="marqueeContainer">
            <div class="flex gap-6 animate-marquee whitespace-nowrap" id="marqueeContent">
                <?php
                if (!empty($db_projects)) {
                    // Triple the array for seamless scroll
                    $items = array_merge($db_projects, $db_projects, $db_projects);
                    foreach ($items as $p): ?>
                        <a href="projectdetail.php?id=<?= $p['id'] ?>" class="w-64 flex-shrink-0 inline-block whitespace-normal group relative">
                            <div class="absolute inset-0 bg-primary/5 rounded-2xl scale-0 group-hover:scale-110 transition-transform duration-500 blur-xl"></div>

                            <div class="aspect-[4/5] rounded-2xl mb-4 shadow-sm group-hover:opacity-90 transition-all relative z-10 overflow-hidden bg-gray-100">
                                <?php if (!empty($p['image_url'])): ?>
                                    <img src="<?= htmlspecialchars($p['image_url']) ?>"
                                        alt="<?= htmlspecialchars($p['title']) ?>"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400 text-[10px] italic">No Image</div>
                                <?php endif; ?>
                            </div>

                            <div class="px-1 relative z-10">
                                <span class="text-[9px] font-black uppercase tracking-widest text-primary mb-1 block"><?= htmlspecialchars($p['category']) ?></span>
                                <h3 class="font-display text-lg font-bold group-hover:text-primary transition-colors"><?= htmlspecialchars($p['title']) ?></h3>
                            </div>
                        </a>
                <?php endforeach;
                } else {
                    echo "<p class='opacity-30 italic text-sm'>No projects found in database...</p>";
                }
                ?>
            </div>
        </div>
    </section>

    <section id="contact" class="relative py-24 px-6 border-t border-gray-50 overflow-hidden">
        <div class="shape-blob w-72 h-72 bg-primary/10 -top-20 right-0"></div>
        <div class="absolute bottom-10 left-20 text-accent animate-twinkle text-4xl">✦</div>

        <div class="max-w-3xl mx-auto text-center relative z-10">
            <h2 class="font-display text-5xl font-black mb-4">Let's Connect</h2>
            <p class="text-xs opacity-40 mb-12 uppercase tracking-widest">Get in touch</p>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <?php
                $links = ["LinkedIn", "Behance", "Dribbble", "Instagram", "Email"];
                foreach ($links as $link): ?>
                    <a href="#" class="bg-white py-6 rounded-xl border border-gray-100 text-[10px] font-bold uppercase tracking-widest opacity-40 hover:opacity-100 hover:border-primary/30 hover:shadow-lg transition-all group overflow-hidden relative">
                        <span class="relative z-10"><?= $link ?></span>
                        <div class="absolute -bottom-2 -right-2 text-primary opacity-0 group-hover:opacity-100 transition-opacity text-[8px]">✦</div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <footer class="py-10 text-center text-[9px] font-bold opacity-20 uppercase tracking-[0.3em]">
        © 2026 Portfolio • Refined Edition
    </footer>

    <script>
        const slider = document.getElementById('marqueeContainer');
        let isDown = false;
        let startX;
        let scrollLeft;

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.classList.add('active');
            slider.classList.replace('cursor-grab', 'cursor-grabbing');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });

        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.classList.remove('active');
            slider.classList.replace('cursor-grabbing', 'cursor-grab');
        });

        slider.addEventListener('mouseup', () => {
            isDown = false;
            slider.classList.remove('active');
            slider.classList.replace('cursor-grabbing', 'cursor-grab');
        });

        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2; // Adjust scroll speed here
            slider.scrollLeft = scrollLeft - walk;
        });
    </script>

</body>

</html>