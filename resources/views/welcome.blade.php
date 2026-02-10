<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaewfa Coffee | ประสบการณ์กาแฟที่ดีที่สุด</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Anuphan', sans-serif;
            scroll-behavior: smooth;
        }
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        /* Custom map placeholder style */
        .map-bg {
            background-color: #e5e7eb;
            background-image: radial-gradient(#d1d5db 2px, transparent 2px);
            background-size: 30px 30px;
        }
    </style>
</head>

<body class="bg-[#faf9f6] text-slate-800">

<!-- ===== NAVBAR ===== -->
<!-- ===== NAVBAR ===== -->
<nav class="fixed top-0 w-full bg-white/80 backdrop-blur shadow-sm z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <!-- LOGO -->
        <a href="{{ url('/') }}" class="text-2xl font-serif font-bold text-indigo-600">
            Kaewfa Coffee
        </a>

        <!-- MENU -->
        <div class="hidden md:flex items-center space-x-6">
            <a href="#about" class="hover:text-indigo-600 transition">เกี่ยวกับเรา</a>
            <a href="#menu" class="hover:text-indigo-600 transition">เมนู</a>
            <a href="#contact" class="hover:text-indigo-600 transition">ติดต่อเรา</a>

            <!-- AUTH -->
            <div class="flex items-center gap-4 border-l pl-6 border-gray-200">

                @guest
                    <!-- ยังไม่ login -->
                    <a href="{{ route('login') }}"
                       class="font-semibold text-indigo-600 hover:underline">
                        เข้าสู่ระบบ
                    </a>

                    <a href="{{ route('register') }}"
                       class="px-4 py-2 bg-indigo-600 text-white rounded-xl
                              hover:bg-indigo-700 transition shadow-md shadow-indigo-100">
                        สมัครสมาชิก
                    </a>
                @endguest

                @auth
                    <!-- login แล้ว -->
                    <span class="text-gray-700 font-medium">
                        👋 {{ Auth::user()->name }}
                    </span>

                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 bg-indigo-100 text-indigo-600 rounded-xl
                              hover:bg-indigo-200 transition font-semibold">
                        Dashboard
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 bg-red-500 text-white rounded-xl
                                       hover:bg-red-600 transition font-semibold">
                            ออกจากระบบ
                        </button>
                    </form>
                @endauth

            </div>
        </div>
    </div>
</nav>
    

<!-- ===== HERO ===== -->
<section class="pt-40 pb-24 text-center px-6">
    <span class="inline-block px-4 py-1.5 bg-indigo-50 text-indigo-600 rounded-full text-sm font-medium mb-6">
        ✨ ค้นพบรสชาติใหม่ที่รอคุณอยู่
    </span>
    <h2 class="text-5xl md:text-7xl font-serif font-bold mb-6 leading-tight">
        กาแฟที่ใช่ <br class="hidden md:block"> สำหรับวันพิเศษของคุณ
    </h2>

    <p class="max-w-2xl mx-auto text-lg text-gray-600 mb-10">
        Kaewfa Coffee คัดสรรเมล็ดกาแฟคุณภาพชั้นเลิศจากดอยสูง 
        พร้อมประสบการณ์การดื่มกาแฟที่อบอุ่นและพรีเมียมในทุกแก้ว
    </p>

    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="#menu" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl text-lg font-semibold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition">
            ดูเมนูของเรา
        </a>
        <a href="#contact" class="px-10 py-4 bg-white text-indigo-600 border border-indigo-100 rounded-2xl text-lg font-semibold hover:bg-indigo-50 transition">
            ค้นหาสาขา
        </a>
    </div>
</section>

<!-- ===== ABOUT ===== -->
<section id="about" class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h3 class="text-3xl font-serif font-bold mb-6">เกี่ยวกับ Kaewfa Coffee</h3>
        <div class="w-16 h-1 bg-indigo-600 mx-auto mb-8 rounded-full"></div>
        <p class="text-gray-600 max-w-3xl mx-auto text-lg leading-relaxed">
            เราเชื่อว่ากาแฟไม่ใช่แค่เครื่องดื่ม แต่คือช่วงเวลาพักผ่อนและแรงบันดาลใจ 
            ไม่ว่าจะเป็นการเริ่มต้นเช้าวันใหม่ที่สดใส หรือการนั่งพักคุยกับเพื่อนสนิท 
            ทุกแก้วของเราถูกชงด้วยความตั้งใจและความใส่ใจในรายละเอียดจากบาริสต้าผู้เชี่ยวชาญ
        </p>
    </div>
</section>

<!-- ===== MENU ===== -->
<section id="menu" class="py-24 bg-[#faf9f6]">
    <div class="max-w-6xl mx-auto px-6">
        <h3 class="text-3xl font-serif font-bold text-center mb-12">เมนูแนะนำ</h3>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="group bg-white p-8 rounded-3xl shadow-sm border border-transparent hover:border-indigo-100 hover:shadow-xl hover:shadow-indigo-50 transition-all duration-300">
                <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center mb-6 text-orange-600">
                    <i data-lucide="coffee"></i>
                </div>
                <h4 class="text-xl font-bold mb-2">Hot Americano</h4>
                <p class="text-gray-600">กาแฟดำรสชาติเข้มข้น หอมกรุ่นจากเมล็ดคั่วกลาง คัดพิเศษ</p>
            </div>

            <div class="group bg-white p-8 rounded-3xl shadow-sm border border-transparent hover:border-indigo-100 hover:shadow-xl hover:shadow-indigo-50 transition-all duration-300">
                <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 text-blue-600">
                    <i data-lucide="cup-soda"></i>
                </div>
                <h4 class="text-xl font-bold mb-2">Latte Art</h4>
                <p class="text-gray-600">สัมผัสนมสดแท้ผสมผสานกับเอสเพรสโซ่ช็อต ให้ความนุ่มละมุนลิ้น</p>
            </div>

            <div class="group bg-white p-8 rounded-3xl shadow-sm border border-transparent hover:border-indigo-100 hover:shadow-xl hover:shadow-indigo-50 transition-all duration-300">
                <div class="w-12 h-12 bg-purple-100 rounded-2xl flex items-center justify-center mb-6 text-purple-600">
                    <i data-lucide="ice-cream"></i>
                </div>
                <h4 class="text-xl font-bold mb-2">Signature Mocha</h4>
                <p class="text-gray-600">การผสมผสานที่ลงตัวระหว่างช็อกโกแลตพรีเมียมและกาแฟเข้มข้น</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== CONTACT & LOCATION ===== -->
<section id="contact" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16">
            
            <!-- Left: Contact Form -->
            <div class="bg-[#faf9f6] p-8 md:p-12 rounded-[2rem] shadow-sm border border-gray-100">
                <h3 class="text-3xl font-serif font-bold mb-2">ติดต่อเรา</h3>
                <p class="text-gray-600 mb-8">หากคุณมีข้อเสนอแนะ แจ้งปัญหา หรืออยากร่วมงานกับเรา ส่งข้อความมาหาเราได้เลยครับ</p>
                
                <form id="contactForm" class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold mb-2 text-gray-700">ชื่อ-นามสกุล</label>
                            <input type="text" placeholder="คุณสมชาย ใจดี" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2 text-gray-700">อีเมล</label>
                            <input type="email" placeholder="example@email.com" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700">เรื่องที่ต้องการแจ้ง</label>
                        <select class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition bg-white">
                            <option>แนะนำติชมทั่วไป</option>
                            <option>แจ้งปัญหาการใช้บริการ</option>
                            <option>สอบถามเมนูและโปรโมชั่น</option>
                            <option>อื่นๆ</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700">ข้อความของคุณ</label>
                        <textarea rows="4" placeholder="พิมพ์รายละเอียดที่นี่..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"></textarea>
                    </div>

                    <button type="button" onclick="handleSubmit()" class="w-full py-4 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all flex items-center justify-center gap-2">
                        <i data-lucide="send" class="w-5 h-5"></i>
                        ส่งข้อความ
                    </button>
                    <p id="successMessage" class="hidden text-green-600 text-sm text-center font-medium mt-4">ส่งข้อมูลเรียบร้อยแล้ว ทีมงานจะติดต่อกลับโดยเร็วที่สุด!</p>
                </form>
            </div>

            <!-- Right: Address & Map -->
            <div class="flex flex-col justify-center">
                <div class="mb-10">
                    <h3 class="text-3xl font-serif font-bold mb-6">ที่อยู่และการเดินทาง</h3>
                    
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 flex-shrink-0">
                                <i data-lucide="map-pin"></i>
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">Kaewfa Coffee</h5>
                                <p class="text-gray-600">9 ถนน ทหาร แขวงถนนนครไชยศรี เขตดุสิต กรุงเทพมหานคร 10300</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 flex-shrink-0">
                                <i data-lucide="phone"></i>
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">เบอร์โทรศัพท์</h5>
                                <p class="text-gray-600">02-123-4567, 081-234-5678</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 flex-shrink-0">
                                <i data-lucide="clock"></i>
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">เวลาเปิดให้บริการ</h5>
                                <p class="text-gray-600">จันทร์ - ศุกร์: 07:00 - 18:00 น. <br>เสาร์ - อาทิตย์: 08:30 - 20:00 น.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fake Map Container -->
                <div class="map-bg w-full h-64 rounded-3xl overflow-hidden relative border border-gray-200 shadow-inner flex items-center justify-center">
                    <div class="absolute inset-0 opacity-40 bg-[url('https://www.transparenttextures.com/patterns/graphy.png')]"></div>
                    <div class="relative z-10 text-center">
                        <div class="bg-white p-3 rounded-full shadow-lg inline-block text-indigo-600 mb-2">
                            <i data-lucide="map-pin" class="w-8 h-8 fill-indigo-100"></i>
                        </div>
                        <p class="font-bold text-gray-800">คลิกเพื่อดู Google Maps</p>
                        <p class="text-sm text-gray-500">9 ถนน ทหาร แขวงถนนนครไชยศรี เขตดุสิต กรุงเทพมหานคร 10300</p>
                    </div>
                    <a href="https://maps.app.goo.gl/P3bh2QqYhjQ1UD65A" target="_blank" class="absolute inset-0 z-20 hover:bg-black/5 transition"></a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="py-16 bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-2xl font-serif font-bold text-indigo-600 mb-8">Kaewfa Coffee</h2>
        
        <div class="flex justify-center space-x-8 mb-8">
            <a href="#" class="text-gray-400 hover:text-indigo-600 transition"><i data-lucide="facebook"></i></a>
            <a href="#" class="text-gray-400 hover:text-indigo-600 transition"><i data-lucide="instagram"></i></a>
            <a href="#" class="text-gray-400 hover:text-indigo-600 transition"><i data-lucide="twitter"></i></a>
        </div>

        <p class="text-gray-500 mb-4">&copy; 2024 Kaewfa Coffee. สงวนลิขสิทธิ์ทุกประการ</p>
        
        <div class="space-x-4 text-sm font-medium text-gray-400">
            <a href="#" class="hover:text-indigo-600 transition underline underline-offset-4">ข้อตกลงการใช้งาน</a>
            <a href="#" class="hover:text-indigo-600 transition underline underline-offset-4">นโยบายความเป็นส่วนตัว</a>
        </div>
    </div>
</footer>

<script>
    // Initialize Lucide Icons
    lucide.createIcons();

    // Form submission mockup logic
    function handleSubmit() {
        const successMsg = document.getElementById('successMessage');
        const form = document.getElementById('contactForm');
        
        // Show success message
        successMsg.classList.remove('hidden');
        
        // Reset form
        form.reset();
        
        // Hide after 5 seconds
        setTimeout(() => {
            successMsg.classList.add('hidden');
        }, 5000);
    }
</script>

</body>
</html>