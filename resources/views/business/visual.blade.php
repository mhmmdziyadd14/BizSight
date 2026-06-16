<x-app-layout>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    
    <style>
        :root {
            --ora: #F97316;
            --ora-lt: #FFF7ED;
            --ora-dk: #EA580C;
            --blk: #0F172A;
            --bg: #ffffff;
            --bg2: #f8fafc;
            --bg3: #f1f5f9;
            --bd: #e2e8f0;
            --bd2: #cbd5e1;
            --t1: #1e293b;
            --t2: #475569;
            --t3: #94a3b8;
            --grn: #16a34a;
            --grn-lt: #f0fdf4;
            --grn-bd: #86efac;
            --red: #ef4444;
            --red-lt: #fef2f2;
            --red-bd: #fca5a5;
            --rad: 14px;
            --radlg: 24px;
        }

        .dark {
            --bg: #0F172A;
            --bg2: #1E293B;
            --bg3: #020617;
            --bd: #334155;
            --bd2: #475569;
            --t1: #f8fafc;
            --t2: #cbd5e1;
            --t3: #94a3b8;
            --blk: #ffffff;
            --ora-lt: rgba(249, 115, 22, 0.15);
            --grn-lt: rgba(22, 163, 74, 0.1);
            --grn-bd: rgba(22, 163, 74, 0.4);
            --red-lt: rgba(239, 68, 68, 0.1);
            --red-bd: rgba(239, 68, 68, 0.4);
        }

        .vcp-container { display: grid; grid-template-columns: 280px 1fr; min-height: calc(100vh - 64px); background: var(--bg2); }
        .vcp-sidebar { background: var(--bg); border-right: 1px solid var(--bd); display: flex; flex-direction: column; position: sticky; top: 0; height: calc(100vh - 64px); overflow-y: auto; z-index: 10; scrollbar-width: none; }
        .vcp-sidebar::-webkit-scrollbar { display: none; }
        .vcp-main { padding: 48px 40px; max-width: 1200px; margin: 0 auto; width: 100%; }

        .sb-top { padding: 24px; border-bottom: 1px solid var(--bd); }
        .pbar-lbl { display: flex; justify-content: space-between; font-size: 11px; color: var(--t3); margin-bottom: 8px; font-weight: 700; text-transform: uppercase; }
        .pbar { height: 6px; background: var(--bg3); border-radius: 10px; overflow: hidden; }
        .pbar-fill { height: 100%; background: var(--ora); transition: 0.5s; width: 0%; }
        
        .sb-nav { padding: 12px 0; flex: 1; }
        .sb-sec { font-size: 10px; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; color: var(--t3); padding: 16px 24px 8px; }
        
        .nv { display: flex; align-items: center; gap: 12px; padding: 12px 24px; font-size: 14px; color: var(--t2); cursor: pointer; border-left: 4px solid transparent; transition: all 0.2s; font-weight: 600; }
        .nv:hover { background: var(--ora-lt); color: var(--ora); }
        .nv.on { background: var(--ora-lt); color: var(--ora); border-left-color: var(--ora); }
        
        .nb { width: 22px; height: 22px; border-radius: 50%; border: 2px solid var(--bd2); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800; color: var(--t3); transition: 0.2s; }
        .nv.on .nb { background: var(--ora); border-color: var(--ora); color: #fff; }
        .nv.ai-done .nb { background: var(--grn-lt); border-color: var(--grn-bd); color: var(--grn); }

        .pg { display: none; animation: fadeIn 0.3s ease-out; }
        .pg.on { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .eyebrow { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 30px; margin-bottom: 12px; text-transform: uppercase; }
        .ey-ora { background: var(--ora-lt); color: var(--ora); border: 1px solid rgba(249, 115, 22, 0.2); }
        .ey-ai { background: var(--grn-lt); color: var(--grn); border: 1px solid var(--grn-bd); }

        .ph1 { font-size: 36px; font-weight: 900; margin-bottom: 8px; color: var(--blk); letter-spacing: -0.04em; }
        .psub { font-size: 16px; color: var(--t2); margin-bottom: 40px; line-height: 1.6; font-weight: 500; }

        .card { background: var(--bg); border: 1px solid var(--bd); border-radius: var(--radlg); padding: 32px; margin-bottom: 32px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.05); transition: transform 0.2s, box-shadow 0.2s; }
        .card:hover { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08); }
        .ct { font-size: 13px; font-weight: 900; color: var(--ora); margin-bottom: 24px; display: flex; align-items: center; gap: 10px; text-transform: uppercase; letter-spacing: 0.1em; }
        .cd { width: 12px; height: 3px; border-radius: 4px; background: var(--ora); }

        .fg { margin-bottom: 24px; }
        .fl { display: block; font-size: 10px; font-weight: 800; color: var(--t3); margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.08em; }
        .fi, .fs, .fta { width: 100%; padding: 14px 18px; border: 1.5px solid var(--bd); border-radius: var(--rad); background: var(--bg2); color: var(--t1); font-size: 14px; transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1); font-weight: 600; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02); }
        .fi::placeholder { color: var(--t3); font-weight: 500; opacity: 0.5; }
        .fi:focus, .fs:focus, .fta:focus { outline: none; border-color: var(--ora); box-shadow: 0 0 0 4px var(--ora-lt), 0 4px 12px rgba(0,0,0,0.05); background: var(--bg); }
        .fi.af, .fta.af, .fs.af { border-color: var(--grn-bd); background: var(--grn-lt); color: var(--grn); }
        .dark .fi.af, .dark .fta.af, .dark .fs.af { color: #86efac; }

        .g2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .g3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
        .g4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }

        .tg-grp { display: flex; gap: 8px; flex-wrap: wrap; }
        .tg { font-size: 12px; padding: 8px 16px; border-radius: 30px; border: 1px solid var(--bd); cursor: pointer; background: var(--bg); color: var(--t2); transition: all 0.2s; font-weight: 700; }
        .tg:hover { border-color: var(--ora); color: var(--ora); }
        .tg.on { background: var(--ora); color: #fff; border-color: var(--ora); }

        .img-upload-wrap { position: relative; cursor: pointer; }
        .img-upload-wrap input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; z-index: 2; }
        .img-upload-box { border: 2px dashed var(--bd2); border-radius: var(--radlg); padding: 32px; text-align: center; background: var(--bg2); transition: 0.2s; }
        .img-upload-wrap:hover .img-upload-box { border-color: var(--ora); background: var(--ora-lt); }
        .img-upload-box.has-img { border-style: solid; border-color: var(--grn-bd); background: var(--grn-lt); }

        .cp-body { padding: 60px 40px; text-align: center; min-height: 300px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; border-radius: var(--radlg) var(--radlg) 0 0; transition: 0.3s; }
        .cp-tl { position: absolute; top: 24px; left: 24px; background: rgba(0,0,0,0.3); padding: 8px 16px; border-radius: 8px; backdrop-filter: blur(4px); }
        .cp-brand { font-size: 72px; font-weight: 900; color: #fff; text-transform: uppercase; letter-spacing: -0.04em; line-height: 1; text-shadow: 0 4px 12px rgba(0,0,0,0.3); }
        .cp-logo-area { width: 80px; height: 80px; margin: 20px 0; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; }
        .cp-for { font-size: 14px; color: rgba(255,255,255,0.8); font-weight: 700; margin-top: 24px; text-transform: uppercase; letter-spacing: 0.1em; }
        .cp-rec { font-size: 18px; color: #fff; font-weight: 800; margin-top: 4px; }
        .cp-foot { background: var(--blk); padding: 16px 40px; display: flex; justify-content: space-between; border-radius: 0 0 var(--radlg) var(--radlg); }
        .cp-foot span { font-size: 11px; color: rgba(255,255,255,0.5); font-weight: 700; text-transform: uppercase; }

        .tbl { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 14px; }
        .tbl th { background: var(--bg3); padding: 16px; text-align: left; font-size: 10px; font-weight: 900; color: var(--t3); text-transform: uppercase; letter-spacing: 0.1em; border-bottom: 2px solid var(--bd); }
        .tbl td { padding: 16px; border-bottom: 1.5px solid var(--bd); }
        .tbl tr:last-child td { border-bottom: none; }
        .tbl .fi, .tbl .fs { padding: 8px 12px; font-size: 13px; background: transparent; border-color: transparent; }
        .tbl .fi:focus { background: var(--bg2); border-color: var(--ora); }
        
        .btn-pdf { display: flex; align-items: center; gap: 10px; padding: 14px 28px; border: none; border-radius: var(--rad); background: var(--ora); color: #fff; font-size: 14px; font-weight: 900; cursor: pointer; transition: all 0.25s; box-shadow: 0 4px 12px var(--ora-lt); }
        .btn-pdf:hover { background: var(--ora-dk); transform: translateY(-2px); box-shadow: 0 8px 20px var(--ora-lt); }
        .btn-pdf.blk { background: var(--t1); color: var(--bg); box-shadow: none; }
        .btn-pdf.blk:hover { background: var(--t2); }
        
        .sn { display: flex; justify-content: space-between; align-items: center; margin-top: 40px; padding-top: 24px; border-top: 1px solid var(--bd); }
        .bp { font-size: 14px; padding: 12px 24px; border: 1px solid var(--bd); border-radius: var(--rad); background: var(--bg); color: var(--t1); font-weight: 700; cursor: pointer; }
        .bn { font-size: 14px; padding: 12px 24px; border: none; border-radius: var(--rad); background: var(--ora); color: #fff; font-weight: 800; cursor: pointer; }
        .bn.blk { background: var(--t1); color: var(--bg); }

        .analyzing { padding: 40px; text-align: center; background: var(--ora-lt); border: 2px dashed var(--ora); border-radius: var(--radlg); margin-top: 24px; color: var(--ora); }
        .spin { width: 40px; height: 40px; border: 4px solid var(--ora-lt); border-top-color: var(--ora); border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 20px; }
        @keyframes spin { to { transform: rotate(360deg); } }
        
        .ai-result-box { background: var(--grn-lt); border: 1px solid var(--grn-bd); border-radius: var(--radlg); padding: 32px; margin-top: 24px; color: var(--grn); }
        
        .care-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; }
        .ci { padding: 16px; border: 2px solid var(--bd); border-radius: var(--rad); text-align: center; cursor: pointer; transition: 0.2s; position: relative; }
        .ci.on { border-color: var(--ora); background: var(--ora-lt); box-shadow: 0 0 0 2px var(--ora); }
        .ci-ic { font-size: 24px; margin-bottom: 8px; opacity: 0.4; }
        .ci.on .ci-ic { opacity: 1; color: var(--ora); }
        .ci-nm { font-size: 11px; font-weight: 800; color: var(--t2); }
        .ci-ai { position: absolute; top: 4px; right: 4px; font-size: 8px; background: var(--grn); color: #fff; padding: 1px 4px; border-radius: 4px; }

        .tl-wrap { padding: 40px 0; }
        .tl-row { display: flex; justify-content: space-between; position: relative; }
        .tl-line { position: absolute; top: 16px; left: 0; right: 0; height: 2px; background: var(--bd2); z-index: 0; }
        .tl-slot { flex: 1; text-align: center; position: relative; z-index: 1; }
        .tl-dot { width: 32px; height: 32px; border-radius: 50%; background: var(--bg); border: 2px solid var(--bd2); display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-size: 12px; font-weight: 800; color: var(--t3); transition: 0.3s; }
        .tl-dot.done { background: var(--grn-lt); border-color: var(--grn); color: var(--grn); }
        .tl-dot.cur { background: var(--ora); border-color: var(--ora); color: #fff; }
        .tl-lbl { font-size: 11px; font-weight: 700; color: var(--t2); text-transform: uppercase; }

        @media (max-width: 1024px) {
            .vcp-container { grid-template-columns: 1fr; }
            .vcp-sidebar { display: none; }
            .g4, .g3, .g2 { grid-template-columns: 1fr; }
            .care-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>

    <div class="vcp-container">
        <!-- Sidebar Navigation -->
        <div class="vcp-sidebar">
            <div class="sb-top">
                <div class="pbar-lbl"><span>Visual Pack Progress</span><span id="ppct">0%</span></div>
                <div class="pbar"><div class="pbar-fill" id="pfill"></div></div>
            </div>
            <div class="sb-nav">
                <p class="sb-sec">Theme & Style</p>
                <div class="px-6 py-2">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Presets</span>
                        <button onclick="toggleDarkMode()" class="text-slate-400 hover:text-ora transition-colors">
                            <svg id="sun-icon" class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.95 17.95l.707.707M7.05 7.05l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path></svg>
                            <svg id="moon-icon" class="w-4 h-4 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path></svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-4 gap-2">
                        <div class="w-8 h-8 rounded-full border-2 border-white shadow-sm cursor-pointer bg-orange-500" onclick="setTheme('classic')" title="Classic Orange"></div>
                        <div class="w-8 h-8 rounded-full border-2 border-white shadow-sm cursor-pointer bg-emerald-500" onclick="setTheme('emerald')" title="Emerald Pro"></div>
                        <div class="w-8 h-8 rounded-full border-2 border-white shadow-sm cursor-pointer bg-slate-800" onclick="setTheme('midnight')" title="Midnight Slate"></div>
                        <div class="w-8 h-8 rounded-full border-2 border-white shadow-sm cursor-pointer bg-rose-500" onclick="setTheme('rose')" title="Rose Modern"></div>
                    </div>
                </div>

                <p class="sb-sec">Automasi AI</p>
                <div class="nv on" id="nav-0" onclick="gp(0,this)">
                    <div class="nb">✦</div> AI Analisa Produk
                </div>
                
                <p class="sb-sec">Halaman Dokumen</p>
                <div class="nv" id="nav-1" onclick="gp(1,this)">
                    <div class="nb">1</div> Cover Page
                </div>
                <div class="nv" id="nav-2" onclick="gp(2,this)">
                    <div class="nb">2</div> Technical Sheet <span id="chip-2" class="ml-auto text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-black hidden">AI✓</span>
                </div>
                <div class="nv" id="nav-3" onclick="gp(3,this)">
                    <div class="nb">3</div> Revision Log
                </div>
                <div class="nv" id="nav-4" onclick="gp(4,this)">
                    <div class="nb">4</div> Bill of Materials <span id="chip-4" class="ml-auto text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-black hidden">AI✓</span>
                </div>
                <div class="nv" id="nav-5" onclick="gp(5,this)">
                    <div class="nb">5</div> Packaging Spec <span id="chip-5" class="ml-auto text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-black hidden">AI✓</span>
                </div>
                <div class="nv" id="nav-6" onclick="gp(6,this)">
                    <div class="nb">6</div> Care Instruction <span id="chip-6" class="ml-auto text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-black hidden">AI✓</span>
                </div>
                <div class="nv" id="nav-7" onclick="gp(7,this)">
                    <div class="nb">7</div> Sample Checklist
                </div>
                <div class="nv" id="nav-8" onclick="gp(8,this)">
                    <div class="nb">8</div> Production Timeline
                </div>
            </div>
            <div class="p-6 border-t border-slate-100 flex flex-col gap-3">
                <button class="btn-pdf w-full justify-center blk" id="btn-save" onclick="saveVisualData()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    SIMPAN DATA
                </button>
                <button class="btn-pdf w-full justify-center" id="btn-pdf" onclick="generatePDF()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    DOWNLOAD PDF A3
                </button>
                <a href="{{ route('visual.list') }}" class="text-center text-xs font-bold text-slate-400 hover:text-orange-500 mt-2">← KEMBALI KE DAFTAR</a>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="vcp-main">
            
            <!-- PAGE 0: AI UPLOAD -->
            <div class="pg on" id="pg-0">
                <span class="eyebrow ey-ai">✦ AI-Powered Automation</span>
                <h1 class="ph1">Visual Clarity AI</h1>
                <p class="psub">Upload foto produk atau sketsa lo. AI akan menganalisa dan mengisi otomatis field di Technical Sheet, BOM, hingga Packaging.</p>
                
                <div class="card">
                    <div class="ct"><div class="cd"></div> Upload Gambar Utama</div>
                    <label class="img-upload-wrap block">
                        <input type="file" id="ai-img-input" accept="image/*" onchange="handleMainUpload(event)">
                        <div class="img-upload-box" id="main-upz-inner">
                            <div class="w-16 h-16 bg-white border border-slate-200 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="text-lg font-bold text-slate-800">Klik untuk upload foto produk</p>
                            <p class="text-sm text-slate-400">Mendukung format JPG, PNG, WEBP (Max 2MB)</p>
                        </div>
                    </label>
                </div>

                <div class="card">
                    <div class="ct"><div class="cd"></div> Konteks Tambahan</div>
                    <div class="g3">
                        <div class="fg"><label class="fl">Kategori Produk</label><select class="fs" id="ctx-type"><option value="">Auto-detect</option><option>T-Shirt</option><option>Kemeja</option><option>Jaket</option><option>Celana</option></select></div>
                        <div class="fg"><label class="fl">Target Market</label><select class="fs" id="ctx-mkt"><option value="">Auto-detect</option><option>Mass</option><option>Mid</option><option>Premium</option></select></div>
                        <div class="fg"><label class="fl">Catatan</label><input type="text" class="fi" id="ctx-note" placeholder="Oversized fit, dll"></div>
                    </div>
                </div>

                <button id="ai-btn" onclick="doAI()" disabled class="w-full py-5 bg-orange-500 text-white rounded-2xl font-black text-lg shadow-lg shadow-orange-500/20 disabled:opacity-30 flex items-center justify-center gap-3 transition-all hover:bg-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    START AI ANALYSIS
                </button>

                <div id="ai-loading" class="hidden mt-6">
                    <div class="analyzing">
                        <div class="spin"></div>
                        <p class="text-orange-600 font-black text-lg" id="ai-step-txt">Initializing...</p>
                        <p class="text-orange-400 text-sm mt-2" id="ai-step-sub">Step 1 of 7</p>
                    </div>
                </div>

                <div id="ai-result-area" class="mt-6"></div>
                <div id="ai-error-area" class="mt-4"></div>

                <div class="sn">
                    <div></div>
                    <button class="bn" onclick="gp(1,document.getElementById('nav-1'))">Skip to Cover →</button>
                </div>
            </div>

            <!-- PAGE 1: COVER -->
            <div class="pg" id="pg-1">
                <span class="eyebrow ey-ora">Page 1 / 8</span>
                <h1 class="ph1">Document Identity</h1>
                <p class="psub">Set the brand identity and link this visual pack to your saved product.</p>
                <div class="card bg-orange-50 border-orange-200">
                    <div class="g2">
                        <div class="fg">
                            <label class="fl">Nama Visual Pack</label>
                            <input type="text" class="fi" id="vp-name" placeholder="Contoh: Tech Pack Urban Tee v1">
                        </div>
                        <div class="fg">
                            <label class="fl">Link ke Data HPP/Produk (Opsional)</label>
                            <select class="fs" id="vp-product" onchange="autoFillProduct()">
                                <option value="">-- Pilih Produk Terkait --</option>
                                @foreach($products as $prod)
                                    <option value="{{ $prod->id }}" data-name="{{ $prod->name }}" data-hpp="{{ $prod->total_hpp_per_unit }}" data-srp="{{ $prod->target_selling_price }}">{{ $prod->name }} (HPP: Rp{{ number_format($prod->total_hpp_per_unit, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="g2">
                        <div class="fg"><label class="fl">Brand Name</label><input type="text" class="fi" id="c-brand" placeholder="Your Brand" oninput="updateCoverPreview()"></div>
                        <div class="fg">
                            <label class="fl">Logo Brand</label>
                            <div class="img-upload-wrap">
                                <input type="file" accept="image/*" onchange="handleLogoUpload(event)">
                                <div class="img-upload-box py-6 flex flex-col items-center justify-center" id="logo-box">
                                    <p class="text-xs font-bold text-slate-400">UPLOAD LOGO</p>
                                    <p class="text-[9px] text-slate-400 mt-1">(Max 2MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="g3">
                        <div class="fg">
                            <label class="fl">Target Recipient</label>
                            <div class="tg-grp" id="c-recip">
                                <div class="tg on" onclick="t1(this,'c-recip')">Client</div>
                                <div class="tg" onclick="t1(this,'c-recip')">Vendor</div>
                                <div class="tg" onclick="t1(this,'c-recip')">Supplier</div>
                                <div class="tg" onclick="t1(this,'c-recip')">Brand</div>
                            </div>
                        </div>
                        <div class="fg"><label class="fl">Entity Name</label><input type="text" class="fi" id="c-recip-name" placeholder="Company Name" oninput="updateCoverPreview()"></div>
                        <div class="fg"><label class="fl">Document Date</label><input type="date" class="fi" id="c-date"></div>
                    </div>
                </div>
                <div class="card">
                    <div class="cp-body" id="cp-body" style="background: #F97316;">
                        <div class="cp-tl"><p class="text-[10px] text-white font-black tracking-widest">TECHNICAL PACKAGE</p></div>
                        <div class="cp-brand" id="prev-brand">BRAND</div>
                        <div class="cp-logo-area" id="prev-logo-area"><svg class="w-8 h-8 text-white opacity-40" fill="none" stroke="currentColor"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                        <div class="cp-for">Document for:</div>
                        <div class="cp-rec" id="prev-rec">Vendor / Client</div>
                    </div>
                </div>
                <div class="sn"><button class="bp" onclick="gp(0,document.getElementById('nav-0'))">← Back</button><button class="bn" onclick="gp(2,document.getElementById('nav-2'))">Next to Technical Sheet →</button></div>
            </div>

            <!-- PAGE 2: TECHNICAL SHEET -->
            <div class="pg" id="pg-2">
                <span class="eyebrow ey-ora">Page 2 / 8</span>
                <h1 class="ph1">Technical Sheet</h1>
                <div class="card">
                    <div class="g4">
                        <div class="fg"><label class="fl">Product Name</label><input type="text" class="fi" id="f-pname"></div>
                        <div class="fg"><label class="fl">Article No.</label><input type="text" class="fi" id="f-art"></div>
                        <div class="fg"><label class="fl">Class</label><input type="text" class="fi" id="f-class"></div>
                        <div class="fg"><label class="fl">Target SRP</label><input type="text" class="fi" id="f-srp"></div>
                    </div>
                    <div class="g2">
                        <div class="fg"><label class="fl">Vendor Name</label><input type="text" class="fi" id="f-vendor"></div>
                        <div class="fg"><label class="fl">Launch Date</label><input type="date" class="fi" id="f-launch"></div>
                    </div>
                </div>
                <div id="material-specs-container">
                    <div class="card">
                        <div class="ct"><div class="cd"></div> Material & Specs</div>
                        <div class="flex gap-6">
                            <div class="w-1/4">
                                <div class="img-upload-wrap h-full min-h-[140px]">
                                    <input type="file" accept="image/*" onchange="handleVisualUpload(event, 'img-mat-1')">
                                    <div class="img-upload-box h-full flex flex-col items-center justify-center" id="img-mat-1">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">UPLOAD PHOTO</p>
                                        <p class="text-[9px] text-slate-400 mt-1">(Max 2MB)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="w-3/4 flex flex-col justify-between">
                                <div class="g3 mb-4">
                                    <div class="fg mb-0"><label class="fl">Fabric</label><input type="text" class="fi" id="f-fabric"></div>
                                    <div class="fg mb-0"><label class="fl">GSM</label><input type="text" class="fi" id="f-gsm"></div>
                                    <div class="fg mb-0"><label class="fl">Color</label><input type="text" class="fi" id="f-color"></div>
                                </div>
                                <div class="fg mb-4"><label class="fl">Construction</label><textarea class="fta" id="f-construct" rows="2"></textarea></div>
                                <div class="fg mb-0"><label class="fl">AI Analysis Reasoning</label><textarea class="fta" id="f-fabric-reason" rows="2"></textarea></div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="mb-8 mt-[-16px] text-orange-600 font-bold text-sm uppercase" onclick="addMaterialSpec()">+ ADD MATERIAL</button>
                <div class="card">
                    <div class="ct"><div class="cd"></div> Visual Viewpoints</div>
                    <div class="g2">
                        <div class="fg"><label class="fl">Front View</label><div class="img-upload-wrap"><input type="file" accept="image/*" onchange="handleVisualUpload(event, 'img-front')"><div class="img-upload-box flex flex-col items-center justify-center" id="img-front"><p class="text-xs font-bold text-slate-400 uppercase">FRONT VIEW</p><p class="text-[9px] text-slate-400 mt-1">(Max 2MB)</p></div></div></div>
                        <div class="fg"><label class="fl">Back View</label><div class="img-upload-wrap"><input type="file" accept="image/*" onchange="handleVisualUpload(event, 'img-back')"><div class="img-upload-box flex flex-col items-center justify-center" id="img-back"><p class="text-xs font-bold text-slate-400 uppercase">BACK VIEW</p><p class="text-[9px] text-slate-400 mt-1">(Max 2MB)</p></div></div></div>
                    </div>
                    <div class="g2 mt-4" id="detail-views-container">
                        <div class="fg"><label class="fl">Detail 1</label><input type="text" class="fi mb-2" id="d1-label" placeholder="Detail Label"><div class="img-upload-wrap"><input type="file" accept="image/*" onchange="handleVisualUpload(event, 'img-d1')"><div class="img-upload-box flex flex-col items-center justify-center" id="img-d1"><p class="text-xs font-bold text-slate-400 uppercase">UPLOAD DETAIL</p><p class="text-[9px] text-slate-400 mt-1">(Max 2MB)</p></div></div></div>
                        <div class="fg"><label class="fl">Detail 2</label><input type="text" class="fi mb-2" id="d2-label" placeholder="Detail Label"><div class="img-upload-wrap"><input type="file" accept="image/*" onchange="handleVisualUpload(event, 'img-d2')"><div class="img-upload-box flex flex-col items-center justify-center" id="img-d2"><p class="text-xs font-bold text-slate-400 uppercase">UPLOAD DETAIL</p><p class="text-[9px] text-slate-400 mt-1">(Max 2MB)</p></div></div></div>
                    </div>
                    <button class="mt-2 text-orange-600 font-bold text-sm uppercase" onclick="addDetailView()">+ ADD MORE DETAIL</button>
                </div>
                <div class="sn"><button class="bp" onclick="gp(1,document.getElementById('nav-1'))">← Back</button><button class="bn" onclick="gp(3,document.getElementById('nav-3'))">Next to Revision Log →</button></div>
            </div>

            <!-- PAGE 3: REVISION LOG -->
            <div class="pg" id="pg-3">
                <span class="eyebrow ey-ora">Page 3 / 8</span>
                <h1 class="ph1">Revision Log</h1>
                <div class="card">
                    <div class="g3 mb-4">
                        <div class="fg"><label class="fl">Latest Version</label><input type="text" class="fi" id="r-ver" placeholder="v1.0"></div>
                        <div class="fg"><label class="fl">Prepared By</label><input type="text" class="fi" id="r-by"></div>
                        <div class="fg"><label class="fl">Date</label><input type="date" class="fi" id="r-date"></div>
                    </div>
                    <table class="tbl">
                        <thead><tr><th>Date</th><th>Ver</th><th>Notes</th><th>Status</th></tr></thead>
                        <tbody id="rev-body">
                            <tr><td><input type="date" class="fi"></td><td><input type="text" class="fi"></td><td><input type="text" class="fi"></td><td><select class="fs"><option>Approved</option><option>Pending</option></select></td></tr>
                        </tbody>
                    </table>
                    <button class="mt-4 text-orange-600 font-bold" onclick="addRevRow()">+ ADD REVISION ROW</button>
                </div>
                <div class="sn"><button class="bp" onclick="gp(2,document.getElementById('nav-2'))">← Back</button><button class="bn" onclick="gp(4,document.getElementById('nav-4'))">Next to BOM →</button></div>
            </div>

            <!-- PAGE 4: BOM -->
            <div class="pg" id="pg-4">
                <span class="eyebrow ey-ora">Page 4 / 8</span>
                <h1 class="ph1">Bill of Materials</h1>
                <div class="card">
                    <div class="ct"><div class="cd"></div> Fabric & Materials</div>
                    <table class="tbl">
                        <thead><tr><th style="width: 80px;">Image</th><th>Component</th><th>Spec</th><th>Qty</th><th>Price</th></tr></thead>
                        <tbody id="bom-f"></tbody>
                    </table>
                    <button class="mt-4 text-orange-600 font-bold" onclick="addBomRow('bom-f')">+ ADD COMPONENT</button>
                </div>
                <div class="card">
                    <div class="ct"><div class="cd"></div> Trims & Labels</div>
                    <table class="tbl">
                        <thead><tr><th style="width: 80px;">Image</th><th>Component</th><th>Spec</th><th>Qty</th><th>Price</th></tr></thead>
                        <tbody id="bom-t"></tbody>
                    </table>
                    <button class="mt-4 text-orange-600 font-bold" onclick="addBomRow('bom-t')">+ ADD TRIM</button>
                </div>
                <div class="card">
                    <div class="ct"><div class="cd"></div> Summary Costs</div>
                    <div class="g4">
                        <div class="fg"><label class="fl">Material Total</label><input type="text" class="fi" id="bom-mat" placeholder="Rp -"></div>
                        <div class="fg"><label class="fl">Trim Total</label><input type="text" class="fi" id="bom-trim" placeholder="Rp -"></div>
                        <div class="fg"><label class="fl">CMT / Sewing</label><input type="text" class="fi" id="f-cmt" placeholder="Rp -"></div>
                        <div class="fg"><label class="fl">Estimated HPP</label><input type="text" class="fi" id="bom-hpp" placeholder="Rp -"></div>
                    </div>
                </div>
                <div class="sn"><button class="bp" onclick="gp(3,document.getElementById('nav-3'))">← Back</button><button class="bn" onclick="gp(5,document.getElementById('nav-5'))">Next to Packaging →</button></div>
            </div>

            <!-- PAGE 5: PACKAGING -->
            <div class="pg" id="pg-5">
                <span class="eyebrow ey-ora">Page 5 / 8</span>
                <h1 class="ph1">Packaging Spec</h1>
                <div id="packaging-specs-container">
                    <div class="card">
                        <div class="flex gap-6">
                            <div class="w-1/4">
                                <div class="img-upload-wrap h-full min-h-[140px]">
                                    <input type="file" accept="image/*" onchange="handleVisualUpload(event, 'img-packaging-1')">
                                    <div class="img-upload-box h-full flex flex-col items-center justify-center" id="img-packaging-1">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase">UPLOAD PHOTO</p>
                                        <p class="text-[9px] text-slate-400 mt-1">(Max 2MB)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="w-3/4 flex flex-col justify-between">
                                <div class="g4 mb-4">
                                    <div class="fg mb-0"><label class="fl">Packaging Spec</label><input type="text" class="fi" id="f-poly-spec-1"></div>
                                    <div class="fg mb-0"><label class="fl">Polybag Type</label><input type="text" class="fi" id="f-poly-1"></div>
                                    <div class="fg mb-0"><label class="fl">Size (cm)</label><input type="text" class="fi" id="f-poly-sz-1"></div>
                                    <div class="fg mb-0"><label class="fl">Thickness</label><input type="text" class="fi" id="f-poly-th-1"></div>
                                </div>
                                <div class="fg mb-4"><label class="fl">Folding Method</label><div class="tg-grp" id="f-fold-1"><div class="tg" onclick="this.classList.toggle('on')">Flat Fold</div><div class="tg" onclick="this.classList.toggle('on')">Roll</div><div class="tg" onclick="this.classList.toggle('on')">Hanger</div></div></div>
                                <div class="fg mb-0"><label class="fl">AI Packaging Insight</label><textarea class="fta" id="f-poly-why-1" rows="2"></textarea></div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="mb-8 mt-[-16px] text-orange-600 font-bold text-sm uppercase" onclick="addPackagingSpec()">+ ADD PACKAGING</button>
                <div class="card">
                    <div class="ct"><div class="cd"></div> Master Carton</div>
                    <div class="g4">
                        <div class="fg"><label class="fl">Qty/Carton</label><input type="text" class="fi" id="f-ctn-qty"></div>
                        <div class="fg"><label class="fl">Carton Size</label><input type="text" class="fi" id="f-ctn-sz"></div>
                        <div class="fg"><label class="fl">Est Weight</label><input type="text" class="fi" id="f-ctn-wt"></div>
                        <div class="fg"><label class="fl">Max Stack</label><input type="text" class="fi" id="f-ctn-st"></div>
                    </div>
                </div>
                <div class="sn"><button class="bp" onclick="gp(4,document.getElementById('nav-4'))">← Back</button><button class="bn" onclick="gp(6,document.getElementById('nav-6'))">Next to Care Instruction →</button></div>
            </div>

            <!-- PAGE 6: CARE INSTRUCTION -->
            <div class="pg" id="pg-6">
                <span class="eyebrow ey-ora">Page 6 / 8</span>
                <h1 class="ph1">Care Instruction</h1>
                <div class="card">
                    <div class="ct"><div class="cd"></div> Selected Care Symbols</div>
                    <div id="care-symbols-container">
                        @php
                            $care_categories = ['wash', 'bleaching', 'ironing', 'dry_cleaning', 'drying'];
                            $care_symbols = [];
                            foreach ($care_categories as $cat) {
                                $files = glob(public_path("images/care_symbols/{$cat}/*.*"));
                                $care_symbols[$cat] = [];
                                if ($files) {
                                    foreach ($files as $f) {
                                        $name = pathinfo($f, PATHINFO_FILENAME);
                                        // Abaikan file yang berakhiran _logo
                                        if (!str_contains(strtolower($name), '_logo')) {
                                            $care_symbols[$cat][] = [
                                                'name' => $name,
                                                'path' => "images/care_symbols/{$cat}/" . basename($f)
                                            ];
                                        }
                                    }
                                }
                            }
                        @endphp

                        @foreach($care_categories as $cat)
                            <div class="mt-6 mb-3 flex items-center border-b border-slate-100 pb-2">
                                <strong class="uppercase text-slate-700 text-xs font-black">{{ str_replace('_', ' ', $cat) }}</strong>
                            </div>
                            <div class="care-grid mb-4" id="cg-{{ $cat }}">
                                @forelse($care_symbols[$cat] as $sym)
                                    <div class="ci !p-0 overflow-hidden bg-white flex items-center justify-center" data-c="{{ $sym['name'] }}" data-nm="{{ ucwords(str_replace(['-', '_'], ' ', $sym['name'])) }}" data-cat="{{ $cat }}" onclick="tglCi(this, 'cg-{{ $cat }}')">
                                        <img src="{{ asset($sym['path']) }}" class="w-full h-auto aspect-square object-contain care-img">
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 italic col-span-5">Belum ada foto pilihan di folder {{ $cat }}.</p>
                                @endforelse
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card">
                    <div class="ct"><div class="cd"></div> Label Text</div>
                    <div class="g2">
                        <div class="fg"><label class="fl">Bahasa Indonesia</label><textarea class="fta" id="f-care-id" rows="3"></textarea></div>
                        <div class="fg"><label class="fl">English</label><textarea class="fta" id="f-care-en" rows="3"></textarea></div>
                    </div>
                    <div class="g2">
                        <div class="fg"><label class="fl">Composition</label><input type="text" class="fi" id="f-comp"></div>
                        <div class="fg"><label class="fl">Origin</label><input type="text" class="fi" id="f-origin" value="Made in Indonesia"></div>
                    </div>
                </div>
                <div class="sn"><button class="bp" onclick="gp(5,document.getElementById('nav-5'))">← Back</button><button class="bn" onclick="gp(7,document.getElementById('nav-7'))">Next to Sample Checklist →</button></div>
            </div>

            <!-- PAGE 7: SAMPLE CHECKLIST -->
            <div class="pg" id="pg-7">
                <span class="eyebrow ey-ora">Page 7 / 8</span>
                <h1 class="ph1">Sample Approval</h1>
                <div class="card">
                    <div class="g4">
                        <div class="fg"><label class="fl">Rec. Date</label><input type="date" class="fi" id="s-date"></div>
                        <div class="fg"><label class="fl">Sample Type</label><select class="fs" id="s-type"><option>Proto 1</option><option>Proto 2</option><option>Size Set</option><option>PPS</option></select></div>
                        <div class="fg"><label class="fl">From Vendor</label><input type="text" class="fi" id="s-from"></div>
                        <div class="fg"><label class="fl">Size</label><input type="text" class="fi" id="s-size"></div>
                    </div>
                </div>
                <div class="card">
                    <div class="ct"><div class="cd"></div> Quality Points</div>
                    <div id="cl-list">
                        <div class="cl-item flex items-center justify-between py-4 border-b">
                            <input type="text" class="fi !border-none !bg-transparent !p-0 !text-slate-700 !shadow-none !font-bold w-3/4" value="1. Ukuran sesuai Grade Spec">
                            <div class="flex gap-2"><div class="tg" onclick="tglCheck(this)">OK</div><div class="tg" onclick="tglCheck(this)">NOK</div></div>
                        </div>
                        <div class="cl-item flex items-center justify-between py-4 border-b">
                            <input type="text" class="fi !border-none !bg-transparent !p-0 !text-slate-700 !shadow-none !font-bold w-3/4" value="2. Handfeel fabric sesuai standar">
                            <div class="flex gap-2"><div class="tg" onclick="tglCheck(this)">OK</div><div class="tg" onclick="tglCheck(this)">NOK</div></div>
                        </div>
                        <div class="cl-item flex items-center justify-between py-4 border-b">
                            <input type="text" class="fi !border-none !bg-transparent !p-0 !text-slate-700 !shadow-none !font-bold w-3/4" value="3. Kerapian jahitan & SPI">
                            <div class="flex gap-2"><div class="tg" onclick="tglCheck(this)">OK</div><div class="tg" onclick="tglCheck(this)">NOK</div></div>
                        </div>
                    </div>
                    <button class="mt-4 text-orange-600 font-bold text-sm uppercase" onclick="addQualityPoint()">+ ADD MORE QUALITY POINTS</button>
                </div>
                <div class="card">
                    <div class="ct"><div class="cd"></div> Decision</div>
                    <div class="fg"><label class="fl">Status Approval</label><div class="tg-grp" id="f-approval"><div class="tg" onclick="t1(this,'f-approval')">Approved</div><div class="tg" onclick="t1(this,'f-approval')">Approved with Notes</div><div class="tg" onclick="t1(this,'f-approval')">Rejected</div></div></div>
                    <div class="fg"><label class="fl">Vendor Notes</label><textarea class="fta" id="s-notes" rows="2"></textarea></div>
                    <div class="g2">
                        <div class="fg"><label class="fl">Checked By</label><input type="text" class="fi" id="s-qc"></div>
                        <div class="fg"><label class="fl">Decision Date</label><input type="date" class="fi" id="s-dec-date"></div>
                    </div>
                </div>
                <div class="sn"><button class="bp" onclick="gp(6,document.getElementById('nav-6'))">← Back</button><button class="bn" onclick="gp(8,document.getElementById('nav-8'))">Next to Timeline →</button></div>
            </div>

            <!-- PAGE 8: TIMELINE -->
            <div class="pg" id="pg-8">
                <span class="eyebrow ey-ora">Page 8 / 8</span>
                <h1 class="ph1">Production Timeline</h1>
                <div class="card">
                    <div class="tl-wrap">
                        <div class="tl-row">
                            <div class="tl-line"></div>
                            <div class="tl-slot"><div class="tl-dot done">✓</div><div class="tl-lbl">Order</div></div>
                            <div class="tl-slot"><div class="tl-dot cur">2</div><div class="tl-lbl">Prod</div></div>
                            <div class="tl-slot"><div class="tl-dot">3</div><div class="tl-lbl">QC</div></div>
                            <div class="tl-slot"><div class="tl-dot">4</div><div class="tl-lbl">Ship</div></div>
                        </div>
                    </div>
                    <div class="g4 mt-6">
                        <div class="fg"><label class="fl">Start Date</label><input type="date" class="fi" id="tl1"></div>
                        <div class="fg"><label class="fl">End Date</label><input type="date" class="fi" id="tl2"></div>
                    </div>
                    <table class="tbl mt-4">
                        <thead><tr><th>Milestone</th><th>Target</th><th>Actual</th><th>Status</th></tr></thead>
                        <tbody id="tl-body">
                            <tr><td><input type="text" class="fi" value="Fabric Arrival"></td><td><input type="date" class="fi"></td><td><input type="date" class="fi"></td><td><select class="fs"><option>On Track</option><option>Delay</option></select></td></tr>
                        </tbody>
                    </table>
                    <button class="mt-4 text-orange-600 font-bold" onclick="addTlRow()">+ ADD MILESTONE</button>
                    <div class="fg mt-6"><label class="fl">Notes</label><textarea class="fta" id="tl-notes" rows="2"></textarea></div>
                </div>
                <div class="sn"><button class="bp" onclick="gp(7,document.getElementById('nav-7'))">← Back</button><button class="bn blk" onclick="generatePDF()">FINALIZE & DOWNLOAD PDF</button></div>
            </div>

        </div>
    </div>

    <script>
        let IMG = {};
        let existingId = {{ $visual ? $visual->id : 'null' }};
        const existingData = @json($visual ? $visual->data : null);
        const existingImages = @json($visual ? $visual->images : null);
        
        let activeTheme = 'classic';
        
        document.addEventListener('DOMContentLoaded', () => {
            if(existingData) {
                document.getElementById('vp-name').value = existingData.name || '{{ $visual ? $visual->name : '' }}';
                if('{{ $visual ? $visual->hpp_calculation_id : '' }}') {
                    document.getElementById('vp-product').value = '{{ $visual ? $visual->hpp_calculation_id : '' }}';
                }
                
                // Map basic fields
                const m = {
                    'c-brand': existingData.brand, 'c-recip-name': existingData.recipient, 'c-date': existingData.date,
                    'f-pname': existingData.pname, 'f-art': existingData.art, 'f-class': existingData.pclass,
                    'f-srp': existingData.srp, 'f-vendor': existingData.vendor, 'f-launch': existingData.launch,
                    'f-fabric': existingData.fabric, 'f-construct': existingData.construct, 'f-gsm': existingData.gsm,
                    'f-color': existingData.color, 'f-fabric-reason': existingData.fabricReason,
                    'f-care-id': existingData.care_id, 'f-care-en': existingData.care_en, 'f-comp': existingData.comp,
                    'f-origin': existingData.origin, 'bom-hpp': existingData.hpp, 'bom-mat': existingData.bomMat,
                    'bom-trim': existingData.bomTrim, 'f-cmt': existingData.cmt,
                    // Packaging spec fields use -1 suffix
                    'f-poly-spec-1': existingData.polySpec || (existingData.packagingSpecs && existingData.packagingSpecs[0] ? existingData.packagingSpecs[0].spec : null),
                    'f-poly-1': existingData.polyType || (existingData.packagingSpecs && existingData.packagingSpecs[0] ? existingData.packagingSpecs[0].polyType : null),
                    'f-poly-sz-1': existingData.polySz || (existingData.packagingSpecs && existingData.packagingSpecs[0] ? existingData.packagingSpecs[0].polySz : null),
                    'f-poly-th-1': existingData.polyTh || (existingData.packagingSpecs && existingData.packagingSpecs[0] ? existingData.packagingSpecs[0].polyTh : null),
                    'f-poly-why-1': existingData.polyWhy || (existingData.packagingSpecs && existingData.packagingSpecs[0] ? existingData.packagingSpecs[0].polyWhy : null),
                    'f-ctn-qty': existingData.ctnQty, 'f-ctn-sz': existingData.ctnSz, 'f-ctn-wt': existingData.ctnWt,
                    'f-ctn-st': existingData.ctnSt
                };
                
                for(let key in m) {
                    if(document.getElementById(key) && m[key]) {
                        document.getElementById(key).value = m[key];
                    }
                }
                
                // Care symbols
                if(existingData.careSymbols) {
                    document.querySelectorAll('.care-grid .ci').forEach(el => {
                        const nm = el.getAttribute('data-nm');
                        const found = existingData.careSymbols.find(c => {
                            if(typeof c === 'string') return c === nm;
                            return c.name === nm;
                        });
                        if(found) el.classList.add('on');
                    });
                }
                
                // Toggle Groups
                // Restore fold toggle for first packaging card
                const foldVal = existingData.fold || (existingData.packagingSpecs && existingData.packagingSpecs[0] ? existingData.packagingSpecs[0].fold : null);
                if(foldVal) {
                    document.querySelectorAll('#f-fold-1 .tg').forEach(t => { if(foldVal.includes(t.textContent.trim())) t.classList.add('on'); });
                }
                if(existingData.recipType) {
                    document.querySelectorAll('#c-recip .tg').forEach(t => { if(existingData.recipType.includes(t.textContent.trim())) t.classList.add('on'); });
                }
                if(existingData.sApproval) {
                    document.querySelectorAll('#f-approval .tg').forEach(t => { if(existingData.sApproval.includes(t.textContent.trim())) t.classList.add('on'); });
                }

                // Sample Checks
                if(existingData.sChecks) {
                    const checks = document.querySelectorAll('.cl-item');
                    existingData.sChecks.forEach((chk, i) => {
                        if(checks[i] && chk.val) {
                            checks[i].querySelectorAll('.tg').forEach(t => { if(t.textContent.trim() === chk.val.trim()) t.classList.add('on'); });
                        }
                    });
                }

                // Revisions
                if(existingData.revs && existingData.revs.length > 0) {
                    const b = document.getElementById('rev-body');
                    b.innerHTML = '';
                    existingData.revs.forEach(r => {
                        b.innerHTML += `<tr><td><input type="date" class="fi" value="${r.date||''}"></td><td><input type="text" class="fi" value="${r.ver||''}"></td><td><input type="text" class="fi" value="${r.notes||''}"></td><td><select class="fs"><option ${r.status==='Approved'?'selected':''}>Approved</option><option ${r.status==='Pending'?'selected':''}>Pending</option></select></td></tr>`;
                    });
                }

                // BOM Fabric
                if(existingData.bomF && existingData.bomF.length > 0) {
                    const b = document.getElementById('bom-f');
                    b.innerHTML = '';
                    existingData.bomF.forEach(r => {
                        const uid = Math.random().toString(36).substr(2,9);
                        const imgId = r.imgId || `img-bomf-${uid}`;
                        b.innerHTML += `<tr>
                            <td>
                                <div class="img-upload-wrap min-w-[60px] min-h-[60px]">
                                    <input type="file" accept="image/*" onchange="handleVisualUpload(event, '${imgId}')">
                                    <div class="img-upload-box !p-2 flex items-center justify-center h-full w-full border-dashed" id="${imgId}">
                                        <p class="text-[8px] font-bold text-slate-400">IMG</p>
                                    </div>
                                </div>
                            </td>
                            <td><input type="text" class="fi" value="${r.comp||''}"></td>
                            <td><input type="text" class="fi" value="${r.spec||''}"></td>
                            <td><input type="text" class="fi" value="${r.qty||''}"></td>
                            <td><input type="text" class="fi" value="${r.price||''}"></td>
                        </tr>`;
                    });
                }

                // BOM Trim
                if(existingData.bomT && existingData.bomT.length > 0) {
                    const b = document.getElementById('bom-t');
                    b.innerHTML = '';
                    existingData.bomT.forEach(r => {
                        const uid = Math.random().toString(36).substr(2,9);
                        const imgId = r.imgId || `img-bomt-${uid}`;
                        b.innerHTML += `<tr>
                            <td>
                                <div class="img-upload-wrap min-w-[60px] min-h-[60px]">
                                    <input type="file" accept="image/*" onchange="handleVisualUpload(event, '${imgId}')">
                                    <div class="img-upload-box !p-2 flex items-center justify-center h-full w-full border-dashed" id="${imgId}">
                                        <p class="text-[8px] font-bold text-slate-400">IMG</p>
                                    </div>
                                </div>
                            </td>
                            <td><input type="text" class="fi" value="${r.comp||''}"></td>
                            <td><input type="text" class="fi" value="${r.spec||''}"></td>
                            <td><input type="text" class="fi" value="${r.qty||''}"></td>
                            <td><input type="text" class="fi" value="${r.price||''}"></td>
                        </tr>`;
                    });
                }

                // Timeline
                if(existingData.tls && existingData.tls.length > 0) {
                    const b = document.getElementById('tl-body');
                    b.innerHTML = '';
                    existingData.tls.forEach(r => {
                        b.innerHTML += `<tr><td><input type="text" class="fi" value="${r.ms||''}"></td><td><input type="date" class="fi" value="${r.tar||''}"></td><td><input type="date" class="fi" value="${r.act||''}"></td><td><select class="fs"><option ${r.st==='On Track'?'selected':''}>On Track</option><option ${r.st==='Delay'?'selected':''}>Delay</option></select></td></tr>`;
                    });
                }
                
                updateCoverPreview();
            }
            
            if(existingImages) {
                IMG = existingImages;
                for(let key in IMG) {
                    if(document.getElementById(key)) {
                        if(key === 'logo' && document.getElementById('logo-box')) {
                            document.getElementById('logo-box').innerHTML = `<img src="${IMG[key]}" class="max-h-12 mx-auto">`;
                            document.getElementById('prev-logo-area').innerHTML = `<img src="${IMG[key]}" class="max-h-16 mx-auto">`;
                        } else {
                            document.getElementById(key).innerHTML = `<img src="${IMG[key]}" class="max-h-40 mx-auto rounded-lg">`;
                            document.getElementById(key).classList.add('has-img');
                        }
                    }
                }
            }
        });
        
        function autoFillProduct() {
            const sel = document.getElementById('vp-product');
            const opt = sel.options[sel.selectedIndex];
            if(opt.value) {
                document.getElementById('f-pname').value = opt.getAttribute('data-name');
                document.getElementById('f-srp').value = opt.getAttribute('data-srp');
                document.getElementById('bom-hpp').value = opt.getAttribute('data-hpp');
            }
        }

        async function saveVisualData(silent = false) {
            if(!silent) {
                const btn = document.getElementById('btn-save');
                btn.innerHTML = 'MENYIMPAN...';
                btn.disabled = true;
            }
            
            const data = collectAll();
            const payload = {
                _token: '{{ csrf_token() }}',
                id: existingId,
                hpp_calculation_id: document.getElementById('vp-product').value || null,
                name: document.getElementById('vp-name').value || ((data.brand || 'Brand') + ' ' + (data.pname || 'Product')),
                data: data,
                images: IMG
            };
            
            try {
                const res = await fetch('{{ route('business.store-visual') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const r = await res.json();
                if(r.success) {
                    existingId = r.id; 
                    if(!silent) alert('Data Visual Pack berhasil disimpan!');
                } else {
                    if(!silent) alert('Gagal menyimpan: ' + (r.message || 'Error'));
                }
            } catch(e) {
                if(!silent) alert('Terjadi kesalahan jaringan.');
            }
            
            if(!silent) {
                const btn = document.getElementById('btn-save');
                btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg> SIMPAN DATA';
                btn.disabled = false;
            }
        }
        
        const themes = {
            classic: { ora: '#F97316', oraDk: '#EA580C', oraLt: '#FFF7ED', blk: '#0F172A', rgb: [249, 115, 22] },
            emerald: { ora: '#10B981', oraDk: '#059669', oraLt: '#ECFDF5', blk: '#1E293B', rgb: [16, 185, 129] },
            midnight: { ora: '#6366F1', oraDk: '#4F46E5', oraLt: '#EEF2FF', blk: '#020617', rgb: [99, 102, 241] },
            rose: { ora: '#F43F5E', oraDk: '#E11D48', oraLt: '#FFF1F2', blk: '#18181B', rgb: [244, 63, 94] }
        };

        function toggleDarkMode() {
            const html = document.documentElement;
            html.classList.toggle('dark');
            const isDark = html.classList.contains('dark');
            
            // Sync with global theme
            if (isDark) {
                localStorage.theme = 'dark';
            } else {
                localStorage.theme = 'light';
            }
            
            // Trigger storage event manually for other tabs
            window.dispatchEvent(new StorageEvent('storage', {
                key: 'theme',
                newValue: localStorage.theme
            }));
            
            // Broadcast to any iframes if necessary
            const iframes = document.querySelectorAll('iframe');
            iframes.forEach(iframe => {
                if(iframe.contentWindow) {
                    iframe.contentWindow.postMessage({ type: 'THEME_CHANGE', theme: localStorage.theme }, '*');
                }
            });
        }

        function setTheme(t) {
            activeTheme = t;
            const theme = themes[t];
            const root = document.documentElement;
            root.style.setProperty('--ora', theme.ora);
            root.style.setProperty('--ora-dk', theme.oraDk);
            root.style.setProperty('--ora-lt', theme.oraLt);
            root.style.setProperty('--blk', theme.blk);
            
            // Update Cover Preview manually as it uses inline style
            const cp = document.getElementById('cp-body');
            if(cp) cp.style.background = theme.ora;
        }

        function gp(id, el) {
            document.querySelectorAll('.pg').forEach(p => p.classList.remove('on'));
            document.querySelectorAll('.nv').forEach(n => n.classList.remove('on'));
            document.getElementById('pg-' + id).classList.add('on');
            if (el) el.classList.add('on');
            else document.getElementById('nav-'+id).classList.add('on');
            const pct = Math.round((id / 8) * 100);
            document.getElementById('pfill').style.width = pct + '%';
            document.getElementById('ppct').textContent = pct + '%';
            window.scrollTo(0, 0);
        }

        function handleMainUpload(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                IMG['ai-source'] = e.target.result;
                document.getElementById('main-upz-inner').innerHTML = `<img src="${e.target.result}" class="max-h-60 mx-auto rounded-xl">`;
                document.getElementById('ai-btn').disabled = false;
            };
            reader.readAsDataURL(file);
        }

        function handleLogoUpload(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                IMG['logo'] = e.target.result;
                document.getElementById('logo-box').innerHTML = `<img src="${IMG['logo']}" class="max-h-12 mx-auto">`;
                document.getElementById('prev-logo-area').innerHTML = `<img src="${IMG['logo']}" class="max-h-16 mx-auto">`;
            };
            reader.readAsDataURL(file);
        }

        function handleVisualUpload(event, id) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                IMG[id] = e.target.result;
                document.getElementById(id).innerHTML = `<img src="${IMG[id]}" class="max-h-40 mx-auto rounded-lg">`;
                document.getElementById(id).classList.add('has-img');
            };
            reader.readAsDataURL(file);
        }

        function updateCoverPreview() {
            document.getElementById('prev-brand').textContent = document.getElementById('c-brand').value || 'BRAND';
            document.getElementById('prev-rec').textContent = document.getElementById('c-recip-name').value || 'Vendor / Client';
        }

        function t1(el, gid) {
            document.getElementById(gid).querySelectorAll('.tg').forEach(t => t.classList.remove('on'));
            el.classList.add('on');
        }

        function tglCi(el, groupId) { 
            if (groupId) {
                document.getElementById(groupId).querySelectorAll('.ci').forEach(c => {
                    if (c !== el) c.classList.remove('on');
                });
            }
            el.classList.toggle('on'); 
        }
        function tglCheck(el) {
            el.parentElement.querySelectorAll('.tg').forEach(t => t.classList.remove('on'));
            el.classList.add('on');
        }

        async function doAI() {
            if (!IMG['ai-source']) {
                alert('Silakan upload gambar produk terlebih dahulu.');
                return;
            }

            const btn = document.getElementById('ai-btn');
            const loading = document.getElementById('ai-loading');
            const errorArea = document.getElementById('ai-error-area');
            
            btn.classList.add('hidden');
            loading.classList.remove('hidden');
            errorArea.innerHTML = '';
            document.getElementById('ai-result-area').innerHTML = '';
            
            const steps = [
                'Connecting to Clarity AI (Gemini Vision)...',
                'Analyzing image semantics...',
                'Detecting materials and construction...',
                'Formulating BOM...',
                'Generating care instructions...',
                'Finalizing data...'
            ];
            
            // Loop for visual effect
            let stepIndex = 0;
            const stepInterval = setInterval(() => {
                if (stepIndex < steps.length) {
                    document.getElementById('ai-step-txt').textContent = steps[stepIndex];
                    document.getElementById('ai-step-sub').textContent = `Step ${stepIndex+1} of ${steps.length}`;
                    stepIndex++;
                }
            }, 2000);

            try {
                const payload = {
                    _token: '{{ csrf_token() }}',
                    image: IMG['ai-source'],
                    type: document.getElementById('ctx-type').value,
                    market: document.getElementById('ctx-mkt').value,
                    note: document.getElementById('ctx-note').value
                };

                const res = await fetch('{{ route('visual.analyze') }}', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });
                
                const r = await res.json();
                clearInterval(stepInterval);

                if (r.success && r.data) {
                    const ai = r.data;
                    
                    // Auto-fill logic from AI
                    if(ai.pname) fillAI('f-pname', ai.pname);
                    if(ai.fabric) fillAI('f-fabric', ai.fabric);
                    if(ai.gsm) fillAI('f-gsm', ai.gsm);
                    if(ai.pclass) fillAI('f-class', ai.pclass);
                    if(ai.fabricReason) fillAI('f-fabric-reason', ai.fabricReason);
                    if(ai.construct) fillAI('f-construct', ai.construct);
                    // Fill packaging spec fields (first card has suffix -1)
                    if(ai.polySz) fillAI('f-poly-sz-1', ai.polySz);
                    if(ai.polyTh) fillAI('f-poly-th-1', ai.polyTh);
                    if(ai.polyWhy) fillAI('f-poly-why-1', ai.polyWhy);
                    if(ai.polyType) fillAI('f-poly-1', ai.polyType);
                    if(ai.polySpec) fillAI('f-poly-spec-1', ai.polySpec);
                    if(ai.care_id) fillAI('f-care-id', ai.care_id);
                    if(ai.care_en) fillAI('f-care-en', ai.care_en);
                    
                    // Mark symbols
                    if(ai.symbols && Array.isArray(ai.symbols)) {
                        ai.symbols.forEach(c => {
                            const el = document.querySelector(`.ci[data-c="${c}"]`);
                            if(el && !el.classList.contains('on')) { 
                                el.classList.add('on'); 
                                el.innerHTML += '<div class="ci-ai">AI</div>'; 
                            }
                        });
                    }

                    // BOM rows
                    if(ai.bom && Array.isArray(ai.bom) && ai.bom.length > 0) {
                        const bf = document.getElementById('bom-f');
                        bf.innerHTML = '';
                        ai.bom.forEach((b, i) => {
                            const uid = Math.random().toString(36).substr(2,9);
                            bf.innerHTML += `<tr>
                                <td>
                                    <div class="img-upload-wrap min-w-[60px] min-h-[60px]">
                                        <input type="file" accept="image/*" onchange="handleVisualUpload(event, 'img-bomf-${uid}')">
                                        <div class="img-upload-box !p-2 flex items-center justify-center h-full w-full border-dashed" id="img-bomf-${uid}">
                                            <p class="text-[8px] font-bold text-slate-400">IMG</p>
                                        </div>
                                    </div>
                                </td>
                                <td><input type="text" class="fi af" value="${b.comp||''}"></td>
                                <td><input type="text" class="fi af" value="${b.spec||''}"></td>
                                <td><input type="text" class="fi af" value="${b.qty||''}"></td>
                                <td><input type="text" class="fi af" value="${b.price||''}"></td>
                            </tr>`;
                        });
                    }
                    
                    loading.classList.add('hidden');
                    document.getElementById('ai-result-area').innerHTML = `
                        <div class="ai-result-box">
                            <h3 class="font-black mb-2">✦ ANALYSIS COMPLETE</h3>
                            <p class="text-sm mt-1">Clarity AI has populated the technical details based on your visual input. You can now review and adjust the data in each section.</p>
                            <div class="flex gap-3 mt-4">
                                <button onclick="gp(1)" class="px-4 py-2 bg-green-600 text-white rounded-lg font-bold text-sm">View Cover</button>
                                <button onclick="gp(2)" class="px-4 py-2 border border-green-600 text-green-600 rounded-lg font-bold text-sm">View Specs</button>
                                <button onclick="doAI()" class="px-4 py-2 border border-orange-500 text-orange-600 rounded-lg font-bold text-sm ml-auto flex items-center gap-2 hover:bg-orange-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> 
                                    Regenerate
                                </button>
                            </div>
                        </div>
                    `;
                    
                    ['2', '4', '5', '6'].forEach(id => {
                        document.getElementById('chip-'+id).classList.remove('hidden');
                        document.getElementById('nav-'+id).classList.add('ai-done');
                    });
                } else {
                    throw new Error(r.message || 'Unknown error occurred');
                }
            } catch(e) {
                clearInterval(stepInterval);
                loading.classList.add('hidden');
                btn.classList.remove('hidden');
                errorArea.innerHTML = `
                    <div class="p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl">
                        <p class="font-bold">AI Analysis Failed</p>
                        <p class="text-sm mt-1">${e.message}</p>
                        <button onclick="doAI()" class="mt-3 px-4 py-2 bg-red-100 border border-red-300 text-red-700 rounded-lg font-bold text-sm flex items-center gap-2 hover:bg-red-200 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> 
                            Coba Lagi
                        </button>
                    </div>
                `;
            }
        }

        function fillAI(id, val) {
            const el = document.getElementById(id);
            if(el) { el.value = val; el.classList.add('af'); }
        }

        function addRevRow() {
            const tr = document.createElement('tr');
            tr.innerHTML = '<td><input type="date" class="fi"></td><td><input type="text" class="fi"></td><td><input type="text" class="fi"></td><td><select class="fs"><option>Approved</option><option>Pending</option></select></td>';
            document.getElementById('rev-body').appendChild(tr);
        }

        function addBomRow(id) {
            const tr = document.createElement('tr');
            const uid = Math.random().toString(36).substr(2,9);
            tr.innerHTML = `
                <td>
                    <div class="img-upload-wrap min-w-[60px] min-h-[60px]">
                        <input type="file" accept="image/*" onchange="handleVisualUpload(event, 'img-bom-${uid}')">
                        <div class="img-upload-box !p-2 flex items-center justify-center h-full w-full border-dashed" id="img-bom-${uid}">
                            <p class="text-[8px] font-bold text-slate-400">IMG</p>
                        </div>
                    </div>
                </td>
                <td><input type="text" class="fi"></td>
                <td><input type="text" class="fi"></td>
                <td><input type="text" class="fi"></td>
                <td><input type="text" class="fi"></td>
            `;
            document.getElementById(id).appendChild(tr);
        }

        function addTlRow() {
            const tr = document.createElement('tr');
            tr.innerHTML = '<td><input type="text" class="fi"></td><td><input type="date" class="fi"></td><td><input type="date" class="fi"></td><td><select class="fs"><option>On Track</option><option>Delay</option></select></td>';
            document.getElementById('tl-body').appendChild(tr);
        }

        let matCount = 1;
        function addMaterialSpec() {
            matCount++;
            const div = document.createElement('div');
            div.className = 'card mt-4';
            div.innerHTML = `
                <div class="flex justify-between items-center mb-4">
                    <div class="ct mb-0"><div class="cd"></div> Material & Specs ${matCount}</div>
                    <button class="text-red-500 font-bold text-xs" onclick="this.parentElement.parentElement.remove()">REMOVE</button>
                </div>
                <div class="flex gap-6">
                    <div class="w-1/4">
                        <div class="img-upload-wrap h-full min-h-[140px]">
                            <input type="file" accept="image/*" onchange="handleVisualUpload(event, 'img-mat-${matCount}')">
                            <div class="img-upload-box h-full flex flex-col items-center justify-center" id="img-mat-${matCount}">
                                <p class="text-[10px] font-bold text-slate-400 uppercase">UPLOAD PHOTO</p>
                                <p class="text-[9px] text-slate-400 mt-1">(Max 2MB)</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-3/4 flex flex-col justify-between">
                        <div class="g3 mb-4">
                            <div class="fg mb-0"><label class="fl">Fabric</label><input type="text" class="fi" id="f-fabric-${matCount}"></div>
                            <div class="fg mb-0"><label class="fl">GSM</label><input type="text" class="fi" id="f-gsm-${matCount}"></div>
                            <div class="fg mb-0"><label class="fl">Color</label><input type="text" class="fi" id="f-color-${matCount}"></div>
                        </div>
                        <div class="fg mb-4"><label class="fl">Construction</label><textarea class="fta" id="f-construct-${matCount}" rows="2"></textarea></div>
                        <div class="fg mb-0"><label class="fl">Notes</label><textarea class="fta" id="f-fabric-reason-${matCount}" rows="2"></textarea></div>
                    </div>
                </div>
            `;
            document.getElementById('material-specs-container').appendChild(div);
        }

        let pkgCount = 1;
        function addPackagingSpec() {
            pkgCount++;
            const div = document.createElement('div');
            div.className = 'card mt-4';
            div.innerHTML = `
                <div class="flex justify-between items-center mb-4">
                    <div class="ct mb-0"><div class="cd"></div> Packaging Spec ${pkgCount}</div>
                    <button class="text-red-500 font-bold text-xs" onclick="this.parentElement.parentElement.remove()">REMOVE</button>
                </div>
                <div class="flex gap-6">
                    <div class="w-1/4">
                        <div class="img-upload-wrap h-full min-h-[140px]">
                            <input type="file" accept="image/*" onchange="handleVisualUpload(event, 'img-packaging-${pkgCount}')">
                            <div class="img-upload-box h-full flex flex-col items-center justify-center" id="img-packaging-${pkgCount}">
                                <p class="text-[10px] font-bold text-slate-400 uppercase">UPLOAD PHOTO</p>
                                <p class="text-[9px] text-slate-400 mt-1">(Max 2MB)</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-3/4 flex flex-col justify-between">
                        <div class="g4 mb-4">
                            <div class="fg mb-0"><label class="fl">Packaging Spec</label><input type="text" class="fi" id="f-poly-spec-${pkgCount}"></div>
                            <div class="fg mb-0"><label class="fl">Polybag Type</label><input type="text" class="fi" id="f-poly-${pkgCount}"></div>
                            <div class="fg mb-0"><label class="fl">Size (cm)</label><input type="text" class="fi" id="f-poly-sz-${pkgCount}"></div>
                            <div class="fg mb-0"><label class="fl">Thickness</label><input type="text" class="fi" id="f-poly-th-${pkgCount}"></div>
                        </div>
                        <div class="fg mb-4"><label class="fl">Folding Method</label><div class="tg-grp" id="f-fold-${pkgCount}"><div class="tg" onclick="this.classList.toggle('on')">Flat Fold</div><div class="tg" onclick="this.classList.toggle('on')">Roll</div><div class="tg" onclick="this.classList.toggle('on')">Hanger</div></div></div>
                        <div class="fg mb-0"><label class="fl">AI Packaging Insight</label><textarea class="fta" id="f-poly-why-${pkgCount}" rows="2"></textarea></div>
                    </div>
                </div>
            `;
            document.getElementById('packaging-specs-container').appendChild(div);
        }

        let detailCount = 2;
        function addDetailView() {
            detailCount++;
            const div = document.createElement('div');
            div.className = 'fg';
            div.innerHTML = `
                <label class="fl">Detail ${detailCount}</label>
                <input type="text" class="fi mb-2" id="d${detailCount}-label" placeholder="Detail Label">
                <div class="img-upload-wrap">
                    <input type="file" accept="image/*" onchange="handleVisualUpload(event, 'img-d${detailCount}')">
                    <div class="img-upload-box flex flex-col items-center justify-center" id="img-d${detailCount}">
                        <p class="text-xs font-bold text-slate-400 uppercase">UPLOAD DETAIL</p>
                        <p class="text-[9px] text-slate-400 mt-1">(Max 2MB)</p>
                    </div>
                </div>
            `;
            document.getElementById('detail-views-container').appendChild(div);
        }

        function addQualityPoint() {
            const list = document.getElementById('cl-list');
            const num = list.children.length + 1;
            const div = document.createElement('div');
            div.className = 'cl-item flex items-center justify-between py-4 border-b';
            div.innerHTML = `
                <input type="text" class="fi !border-none !bg-transparent !p-0 !text-slate-700 !shadow-none !font-bold w-3/4" value="${num}. Point Inspeksi Baru">
                <div class="flex gap-2"><div class="tg" onclick="tglCheck(this)">OK</div><div class="tg" onclick="tglCheck(this)">NOK</div></div>
            `;
            list.appendChild(div);
        }

        // --- FULL PDF GENERATION LOGIC ---
        function collectAll() {
            const G = id => { const e = document.getElementById(id); return e ? e.value.trim() : ''; };
            const GA = gid => { const e = document.getElementById(gid); return e ? [...e.querySelectorAll('.tg.on')].map(t => t.textContent.trim()).join(', ') : ''; };

            return {
                brand: G('c-brand') || 'BRAND',
                recipient: G('c-recip-name') || 'Vendor / Client',
                recipType: GA('c-recip'),
                date: G('c-date') || new Date().toISOString().split('T')[0],
                pname: G('f-pname') || 'Product Name',
                art: G('f-art') || 'N/A',
                pclass: G('f-class'),
                srp: G('f-srp'),
                vendor: G('f-vendor'),
                launch: G('f-launch'),
                materialSpecs: [...document.querySelectorAll('#material-specs-container .card')].map(c => ({
                    fabric: c.querySelector('[id^="f-fabric"]:not([id^="f-fabric-reason"])')?.value || '',
                    construct: c.querySelector('[id^="f-construct"]')?.value || '',
                    gsm: c.querySelector('[id^="f-gsm"]')?.value || '',
                    color: c.querySelector('[id^="f-color"]')?.value || '',
                    reason: c.querySelector('[id^="f-fabric-reason"]')?.value || '',
                    imgId: c.querySelector('.img-upload-box')?.id
                })),
                details: [...document.querySelectorAll('#detail-views-container .fg')].map(c => ({
                    lbl: c.querySelector('input')?.value || 'Detail',
                    imgId: c.querySelector('.img-upload-box')?.id
                })),
                rVer: G('r-ver'), rBy: G('r-by'), rDate: G('r-date'),
                revs: [...document.querySelectorAll('#rev-body tr')].map(tr => ({
                    date: tr.cells[0].querySelector('input').value,
                    ver: tr.cells[1].querySelector('input').value,
                    notes: tr.cells[2].querySelector('input').value,
                    status: tr.cells[3].querySelector('select').value
                })),
                bomF: [...document.querySelectorAll('#bom-f tr')].map(tr => ({
                    imgId: tr.querySelector('.img-upload-box')?.id,
                    comp: tr.cells[1].querySelector('input').value,
                    spec: tr.cells[2].querySelector('input').value,
                    qty: tr.cells[3].querySelector('input').value,
                    price: tr.cells[4].querySelector('input').value
                })),
                bomT: [...document.querySelectorAll('#bom-t tr')].map(tr => ({
                    imgId: tr.querySelector('.img-upload-box')?.id,
                    comp: tr.cells[1].querySelector('input').value,
                    spec: tr.cells[2].querySelector('input').value,
                    qty: tr.cells[3].querySelector('input').value,
                    price: tr.cells[4].querySelector('input').value
                })),
                bomMat: G('bom-mat'), bomTrim: G('bom-trim'), cmt: G('f-cmt'), hpp: G('bom-hpp'),
                // Collect all packaging spec cards dynamically
                packagingSpecs: [...document.querySelectorAll('#packaging-specs-container .card')].map((c, i) => {
                    const idx = i + 1;
                    return {
                        spec: c.querySelector(`[id^="f-poly-spec-"]`)?.value || '',
                        polyType: c.querySelector(`[id^="f-poly-"]:not([id^="f-poly-spec"]):not([id^="f-poly-sz"]):not([id^="f-poly-th"]):not([id^="f-poly-why"])`)?.value || '',
                        polySz: c.querySelector(`[id^="f-poly-sz-"]`)?.value || '',
                        polyTh: c.querySelector(`[id^="f-poly-th-"]`)?.value || '',
                        fold: [...(c.querySelector(`[id^="f-fold-"]`)?.querySelectorAll('.tg.on') || [])].map(t => t.textContent.trim()).join(', '),
                        polyWhy: c.querySelector(`[id^="f-poly-why-"]`)?.value || '',
                        imgId: c.querySelector('.img-upload-box')?.id
                    };
                }),
                // Legacy single fields for backward compat
                polyType: G('f-poly-1'), polySz: G('f-poly-sz-1'), polyTh: G('f-poly-th-1'), fold: GA('f-fold-1'), polyWhy: G('f-poly-why-1'),
                ctnQty: G('f-ctn-qty'), ctnSz: G('f-ctn-sz'), ctnWt: G('f-ctn-wt'), ctnSt: G('f-ctn-st'),
                careSymbols: [...document.querySelectorAll('.care-grid .ci.on')].map(c => {
                    const img = c.querySelector('img.care-img');
                    return {
                        name: c.getAttribute('data-nm'),
                        imgSrc: img ? img.src : null
                    };
                }),
                care_id: G('f-care-id'), care_en: G('f-care-en'), comp: G('f-comp'), origin: G('f-origin'),
                sDate: G('s-date'), sType: G('s-type'), sFrom: G('s-from'), sSize: G('s-size'),
                sChecks: [...document.querySelectorAll('.cl-item')].map(c => ({
                    lbl: c.querySelector('input') ? c.querySelector('input').value : c.querySelector('p').textContent,
                    val: c.querySelector('.tg.on') ? c.querySelector('.tg.on').textContent : ''
                })),
                sApproval: GA('f-approval'), sNotes: G('s-notes'), sQc: G('s-qc'), sDecDate: G('s-dec-date'),
                tl1: G('tl1'), tl2: G('tl2'), tlNotes: G('tl-notes'),
                tls: [...document.querySelectorAll('#tl-body tr')].map(tr => ({
                    ms: tr.cells[0].querySelector('input').value,
                    tar: tr.cells[1].querySelector('input').value,
                    act: tr.cells[2].querySelector('input').value,
                    st: tr.cells[3].querySelector('select').value
                }))
            };
        }

        async function generatePDF() {
            const btn = document.getElementById('btn-pdf');
            btn.disabled = true;
            btn.innerHTML = 'GENERATING PDF...';
            
            // Save before generating PDF implicitly
            await saveVisualData(true);

            
            try {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a3' });
                const D = collectAll();
                const PW = 420, PH = 297, M = 10, UW = PW - M * 2;
                
                // Color Palette from Active Theme
                const currentTheme = themes[activeTheme];
                const ORA = currentTheme.rgb;
                
                // Helper to convert hex to RGB
                const hexToRgb = (hex) => {
                    const r = parseInt(hex.slice(1, 3), 16);
                    const g = parseInt(hex.slice(3, 5), 16);
                    const b = parseInt(hex.slice(5, 7), 16);
                    return [r, g, b];
                };

                const NAV = hexToRgb(currentTheme.blk);
                const LIGHT_ORA = hexToRgb(currentTheme.oraLt);
                const GREY = [100, 116, 139];
                
                // Helper: Section Bar
                const secBar = (x, y, w, h, label, bg = ORA) => {
                    doc.setFillColor(...bg);
                    doc.rect(x, y, w, h, 'F');
                    doc.setTextColor(255, 255, 255);
                    doc.setFontSize(10);
                    doc.setFont('helvetica', 'bold');
                    doc.text(label, x + 5, y + h * 0.7);
                    doc.setTextColor(...NAV); // Reset text color
                };

                const addHeader = (title) => {
                    doc.setFillColor(...NAV);
                    doc.rect(0, 0, PW, 25, 'F');
                    doc.setTextColor(255, 255, 255);
                    doc.setFontSize(14);
                    doc.text(title, 20, 16);
                    doc.text(D.brand || 'BRAND', PW - 20, 16, { align: 'right' });
                    doc.setTextColor(...NAV);
                };

                // --- PAGE 1: COVER ---
                doc.setFillColor(...ORA);
                doc.rect(0, 0, PW, PH, 'F');
                doc.setFillColor(...NAV);
                doc.rect(0, 0, PW, 30, 'F');
                
                doc.setTextColor(255, 255, 255);
                doc.setFontSize(90);
                doc.setFont('helvetica', 'bold');
                doc.text((D.brand || 'BRAND').toUpperCase(), PW / 2, PH / 2, { align: 'center' });
                
                doc.setFontSize(20);
                doc.text('VISUAL CLARITY PACKAGE', PW / 2, PH / 2 + 25, { align: 'center' });
                
                doc.setFontSize(16);
                doc.text('Prepared for: ' + D.recipient, PW / 2, PH / 2 + 50, { align: 'center' });
                doc.text('Date: ' + D.date, PW / 2, PH / 2 + 60, { align: 'center' });
                
                if(IMG['logo']) {
                    try { 
                        let logoEl = document.querySelector('#prev-logo-area img');
                        if (logoEl) doc.addImage(logoEl, 'PNG', PW/2 - 25, PH/2 - 100, 50, 50); 
                    } catch(e){}
                }

                // --- PAGE 2: TECHNICAL SHEET ---
                doc.addPage();
                addHeader('TECHNICAL SPECIFICATION');

                doc.setTextColor(...NAV);
                doc.setFontSize(28);
                doc.text(D.pname || 'Product Name', 20, 45);
                doc.setFontSize(14);
                doc.setTextColor(...GREY);
                doc.text('Article: ' + D.art + ' | Class: ' + (D.pclass || '-'), 20, 55);

                let ty = 65;
                secBar(20, ty, 180, 8, 'MATERIAL & FABRIC');
                secBar(210, ty, 190, 8, 'VISUALS');
                
                doc.setTextColor(...NAV);
                doc.setFontSize(11);
                let ly = ty + 15;
                
                // Draw Material Specs (up to 2 on this page to fit)
                let renderedMats = 0;
                D.materialSpecs.forEach((mat) => {
                    if (renderedMats >= 2) return;
                    
                    if(mat.imgId && IMG[mat.imgId]) {
                        try { doc.addImage(IMG[mat.imgId], 'JPEG', 25, ly, 25, 25); } catch(e){}
                    }
                    
                    let cy = ly;
                    [['Fabric', mat.fabric], ['Construction', mat.construct], ['GSM', mat.gsm], ['Color', mat.color]].forEach(([l, v]) => {
                        doc.setFont('helvetica', 'bold'); doc.text(l + ':', 55, cy);
                        doc.setFont('helvetica', 'normal'); 
                        const splitText = doc.splitTextToSize(String(v || '-'), 110);
                        doc.text(splitText, 90, cy);
                        cy += (splitText.length * 5) + 1;
                    });
                    
                    if(mat.reason) {
                        cy += 2;
                        doc.setFont('helvetica', 'bold'); doc.text('Notes:', 55, cy);
                        doc.setFont('helvetica', 'normal'); 
                        const splitNotes = doc.splitTextToSize(mat.reason, 145);
                        doc.text(splitNotes, 55, cy + 5);
                        cy += (splitNotes.length * 5) + 5;
                    }
                    
                    ly = Math.max(ly + 35, cy + 10);
                    renderedMats++;
                });

                if(IMG['img-front']) {
                    try { 
                        let fEl = document.querySelector('#img-front img');
                        if (fEl) doc.addImage(fEl, 'JPEG', 210, ty + 12, 60, 80); 
                        doc.text('FRONT VIEW', 240, ty + 97, {align:'center'}); 
                    } catch(e){}
                }
                if(IMG['img-back']) {
                    try { 
                        let bEl = document.querySelector('#img-back img');
                        if (bEl) doc.addImage(bEl, 'JPEG', 280, ty + 12, 60, 80); 
                        doc.text('BACK VIEW', 310, ty + 97, {align:'center'}); 
                    } catch(e){}
                }

                // Draw Detail Views
                let dx = 210;
                let dy = ty + 110;
                D.details.forEach((det, i) => {
                    if(i > 3) return; // Limit to 4 details
                    if(det.imgId && IMG[det.imgId]) {
                        try { doc.addImage(IMG[det.imgId], 'JPEG', dx, dy, 40, 50); } catch(e){}
                    }
                    doc.setFontSize(9);
                    doc.text(det.lbl || 'DETAIL', dx + 20, dy + 55, {align:'center'});
                    dx += 45;
                });

                // --- PAGE 3: REVISION LOG ---
                doc.addPage();
                addHeader('REVISION LOG');
                doc.setFontSize(12);
                doc.text(`Latest Version: ${D.rVer}    |    Prepared By: ${D.rBy}    |    Date: ${D.rDate}`, 20, 45);
                
                secBar(20, 60, 380, 10, 'REVISION HISTORY');
                doc.setFont('helvetica', 'bold'); doc.setFontSize(10);
                doc.text('Date', 25, 80); doc.text('Version', 80, 80); doc.text('Notes', 130, 80); doc.text('Status', 350, 80);
                doc.setDrawColor(...GREY); doc.line(20, 85, 400, 85);
                doc.setFont('helvetica', 'normal');
                let rY = 95;
                D.revs.forEach(r => {
                    doc.text(r.date, 25, rY); doc.text(r.ver, 80, rY); doc.text(doc.splitTextToSize(r.notes, 200), 130, rY); doc.text(r.status, 350, rY);
                    rY += 15;
                });

                // --- PAGE 4: BILL OF MATERIALS ---
                doc.addPage();
                addHeader('BILL OF MATERIALS');
                
                secBar(20, 40, 380, 10, 'SUMMARY COSTS');
                doc.setFillColor(...LIGHT_ORA); doc.rect(20, 50, 380, 20, 'F');
                doc.setFont('helvetica', 'bold'); doc.setFontSize(12); doc.setTextColor(...NAV);
                doc.text(`Material Total: ${D.bomMat || '-'}`, 30, 63);
                doc.text(`Trim Total: ${D.bomTrim || '-'}`, 120, 63);
                doc.text(`CMT/Sewing: ${D.cmt || '-'}`, 210, 63);
                doc.text(`EST. HPP: ${D.hpp || '-'}`, 300, 63);
                
                secBar(20, 85, 380, 8, 'FABRIC & MATERIALS');
                doc.setFontSize(10); doc.text('Image', 25, 103); doc.text('Component', 55, 103); doc.text('Spec', 150, 103); doc.text('Qty', 300, 103); doc.text('Price', 350, 103);
                doc.line(20, 108, 400, 108);
                doc.setFont('helvetica', 'normal');
                rY = 118;
                D.bomF.forEach(r => {
                    if (r.imgId && IMG[r.imgId]) {
                        try { doc.addImage(IMG[r.imgId], 'JPEG', 25, rY - 6, 12, 12); } catch(e) {}
                    }
                    doc.text(r.comp, 55, rY + 2); doc.text(r.spec, 150, rY + 2); doc.text(r.qty, 300, rY + 2); doc.text(r.price, 350, rY + 2);
                    rY += 16;
                });
                
                rY += 10;
                if(rY > 250) { doc.addPage(); rY = 30; } // Basic pagination check
                
                secBar(20, rY, 380, 8, 'TRIMS & LABELS');
                rY += 15;
                doc.setFont('helvetica', 'bold');
                doc.text('Image', 25, rY); doc.text('Component', 55, rY); doc.text('Spec', 150, rY); doc.text('Qty', 300, rY); doc.text('Price', 350, rY);
                doc.line(20, rY+5, 400, rY+5);
                doc.setFont('helvetica', 'normal');
                rY += 15;
                D.bomT.forEach(r => {
                    if (r.imgId && IMG[r.imgId]) {
                        try { doc.addImage(IMG[r.imgId], 'JPEG', 25, rY - 6, 12, 12); } catch(e) {}
                    }
                    doc.text(r.comp, 55, rY + 2); doc.text(r.spec, 150, rY + 2); doc.text(r.qty, 300, rY + 2); doc.text(r.price, 350, rY + 2);
                    rY += 16;
                });

                // --- PAGE 5: PACKAGING SPEC ---
                doc.addPage();
                addHeader('PACKAGING SPECIFICATION');
                
                // Use packagingSpecs array if available, fallback to legacy fields
                const pkgSpecs = (D.packagingSpecs && D.packagingSpecs.length > 0) ? D.packagingSpecs : [{
                    spec: '', polyType: D.polyType, polySz: D.polySz, polyTh: D.polyTh, fold: D.fold, polyWhy: D.polyWhy
                }];
                
                let pkgY = 35;
                pkgSpecs.forEach((pkg, pkgIdx) => {
                    const pkgLabel = pkgSpecs.length > 1 ? `POLYBAG & FOLDING ${pkgIdx + 1}` : 'POLYBAG & FOLDING';
                    secBar(20, pkgY, 185, 9, pkgLabel);
                    doc.setFontSize(10);
                    let pY = pkgY + 16;
                    
                    if(pkg.spec) {
                        doc.setFont('helvetica', 'bold'); doc.text('Spec:', 25, pY);
                        doc.setFont('helvetica', 'normal'); doc.text(String(pkg.spec || '-'), 65, pY); pY += 9;
                    }
                    [['Type', pkg.polyType], ['Size', pkg.polySz], ['Thickness', pkg.polyTh], ['Folding', pkg.fold]].forEach(([l, v]) => {
                        doc.setFont('helvetica', 'bold'); doc.text(l + ':', 25, pY);
                        doc.setFont('helvetica', 'normal'); doc.text(String(v || '-'), 65, pY);
                        pY += 9;
                    });
                    if(pkg.polyWhy) {
                        doc.setFillColor(...LIGHT_ORA); doc.rect(20, pY + 2, 185, 32, 'F');
                        doc.setFont('helvetica', 'bold'); doc.setFontSize(9); doc.text('AI PACKAGING INSIGHT:', 24, pY + 10);
                        doc.setFont('helvetica', 'normal'); doc.text(doc.splitTextToSize(pkg.polyWhy, 175), 24, pY + 18);
                        pY += 36;
                    }
                    pkgY = pY + 8;
                    if(pkgY > 250 && pkgIdx < pkgSpecs.length - 1) { doc.addPage(); addHeader('PACKAGING SPECIFICATION (cont.)'); pkgY = 35; }
                });

                secBar(210, 35, 190, 9, 'MASTER CARTON');
                let ctnY = 53;
                [['Qty/Carton', D.ctnQty], ['Carton Size', D.ctnSz], ['Est Weight', D.ctnWt], ['Max Stack', D.ctnSt]].forEach(([l, v]) => {
                    doc.setFont('helvetica', 'bold'); doc.setFontSize(10); doc.text(l + ':', 215, ctnY);
                    doc.setFont('helvetica', 'normal'); doc.text(String(v || '-'), 270, ctnY);
                    ctnY += 9;
                });

                // --- PAGE 6: CARE INSTRUCTION ---
                doc.addPage();
                addHeader('CARE INSTRUCTION');
                secBar(20, 45, 380, 10, 'SELECTED CARE SYMBOLS');
                doc.setFontSize(12); doc.setFont('helvetica', 'normal');
                if (D.careSymbols && D.careSymbols.length > 0) {
                    let cx = 30;
                    let cy = 65;
                    D.careSymbols.forEach(sym => {
                        const symName = typeof sym === 'string' ? sym : sym.name;
                        const symImgSrc = typeof sym === 'string' ? null : sym.imgSrc;
                        
                        if (symImgSrc) {
                            // Find the image element in the DOM to pass to jsPDF
                            const imgEls = document.querySelectorAll('.care-img');
                            let targetImg = null;
                            for (let img of imgEls) {
                                if (img.src === symImgSrc) {
                                    targetImg = img;
                                    break;
                                }
                            }
                            if (targetImg) {
                                try {
                                    doc.addImage(targetImg, 'PNG', cx, cy, 12, 12);
                                } catch(e) {}
                            }
                        }
                        doc.setFontSize(10);
                        doc.text(symName, cx + 15, cy + 8);
                        cx += 65;
                        if (cx > 350) {
                            cx = 30;
                            cy += 20;
                        }
                    });
                } else {
                    doc.text('No symbols selected', 30, 70);
                }
                
                secBar(20, 100, 380, 10, 'LABEL TEXT & COMPOSITION');
                doc.setFontSize(11);
                doc.setFont('helvetica', 'bold'); doc.text('Bahasa Indonesia:', 25, 130);
                doc.setFont('helvetica', 'normal'); doc.text(doc.splitTextToSize(D.care_id, 170), 25, 140);
                doc.setFont('helvetica', 'bold'); doc.text('English:', 215, 130);
                doc.setFont('helvetica', 'normal'); doc.text(doc.splitTextToSize(D.care_en, 170), 215, 140);
                doc.setFont('helvetica', 'bold'); doc.text('Composition:', 25, 180); doc.setFont('helvetica', 'normal'); doc.text(D.comp || '-', 60, 180);
                doc.setFont('helvetica', 'bold'); doc.text('Origin:', 215, 180); doc.setFont('helvetica', 'normal'); doc.text(D.origin || '-', 250, 180);

                // --- PAGE 7: SAMPLE CHECKLIST ---
                doc.addPage();
                addHeader('SAMPLE CHECKLIST');
                doc.setFontSize(11);
                doc.text(`Rec. Date: ${D.sDate}   |   Type: ${D.sType}   |   From: ${D.sFrom}   |   Size: ${D.sSize}`, 20, 45);
                
                secBar(20, 60, 180, 10, 'QUALITY POINTS');
                rY = 85;
                D.sChecks.forEach(c => {
                    doc.setFont('helvetica', 'normal'); doc.text(doc.splitTextToSize(c.lbl, 130), 25, rY);
                    doc.setFont('helvetica', 'bold'); doc.text(c.val || '-', 160, rY);
                    rY += 15;
                });
                
                secBar(210, 60, 190, 10, 'DECISION');
                doc.setFont('helvetica', 'bold'); doc.text('Approval Status:', 215, 85); doc.setFont('helvetica', 'normal'); doc.text(D.sApproval || '-', 260, 85);
                doc.setFont('helvetica', 'bold'); doc.text('Vendor Notes:', 215, 105); doc.setFont('helvetica', 'normal'); doc.text(doc.splitTextToSize(D.sNotes, 170), 215, 115);
                doc.setFont('helvetica', 'bold'); doc.text(`Checked By: ${D.sQc}     |     Decision Date: ${D.sDecDate}`, 215, 155);

                // --- PAGE 8: PRODUCTION TIMELINE ---
                doc.addPage();
                addHeader('PRODUCTION TIMELINE');
                doc.setFontSize(11);
                doc.text(`Est. Start: ${D.tl1}    |    Est. End: ${D.tl2}`, 20, 45);
                
                secBar(20, 60, 380, 10, 'MILESTONES');
                doc.setFont('helvetica', 'bold'); doc.setFontSize(10);
                doc.text('Milestone', 25, 80); doc.text('Target', 150, 80); doc.text('Actual', 230, 80); doc.text('Status', 310, 80);
                doc.line(20, 85, 400, 85);
                doc.setFont('helvetica', 'normal');
                rY = 95;
                D.tls.forEach(t => {
                    doc.text(t.ms, 25, rY); doc.text(t.tar, 150, rY); doc.text(t.act, 230, rY); doc.text(t.st, 310, rY);
                    rY += 15;
                });
                
                doc.setFont('helvetica', 'bold'); doc.text('General Notes:', 20, rY + 10);
                doc.setFont('helvetica', 'normal'); doc.text(doc.splitTextToSize(D.tlNotes, 380), 20, rY + 20);

                doc.save(`VCP_${D.brand || 'Pack'}_${new Date().toISOString().split('T')[0]}.pdf`);
                
            } catch (err) {
                console.error(err);
                alert("Error generating PDF: " + err.message);
            }
            
            btn.disabled = false;
            btn.innerHTML = 'DOWNLOAD PDF A3';
        }
    </script>
</x-app-layout>