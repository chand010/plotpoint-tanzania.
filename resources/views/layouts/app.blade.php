<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'Explore land listings in Tanzania with location-first property discovery.')">
    <title>@yield('title', 'PlotPoint Tanzania') · PlotPoint Tanzania</title>
    @stack('head')
    <style>
        :root { color-scheme: dark; --bg:#071426; --panel:#0e2038; --line:#29415e; --blue:#3b82f6; --blue2:#60a5fa; --text:#f8fafc; --muted:#a8b8cc; }
        * { box-sizing:border-box; } body { margin:0;background:var(--bg);color:var(--text);font:15px/1.55 system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif; } a{color:inherit}
        .container{width:min(1200px,calc(100% - 32px));margin:auto}.topbar{border-bottom:1px solid var(--line);background:#08172a}.nav{min-height:68px;display:flex;align-items:center;justify-content:space-between;gap:20px}
        .brand{text-decoration:none;font-size:1.2rem;font-weight:850;letter-spacing:-.04em}.brand span{color:var(--blue2)}.nav-note{color:var(--muted);font-size:.88rem}
        .hero{padding:34px 0 24px}.eyebrow{color:#93c5fd;font-size:.78rem;text-transform:uppercase;letter-spacing:.13em;font-weight:800}
        h1{font-size:clamp(2rem,5vw,3.35rem);line-height:1.08;letter-spacing:-.05em;margin:10px 0}h2{letter-spacing:-.025em}.muted{color:var(--muted)}
        .search{display:grid;grid-template-columns:2fr 1fr 1fr 1fr 1fr auto;gap:10px;padding:14px;background:var(--panel);border:1px solid var(--line);border-radius:16px}
        label{display:block;color:#d7e3f2;font-size:.78rem;margin-bottom:5px}input,select{width:100%;min-height:42px;border:1px solid #3b526e;border-radius:9px;background:#071426;color:white;padding:9px 10px;font:inherit}
        button,.btn{border:0;border-radius:9px;background:var(--blue);color:white;padding:11px 15px;font:inherit;font-weight:750;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;justify-content:center}.btn-outline{background:transparent;border:1px solid #49617d}
        .section-head{display:flex;align-items:center;justify-content:space-between;gap:16px;margin:28px 0 14px}.section-head h2{margin:0;font-size:1.2rem}
        .market-grid{display:grid;grid-template-columns:minmax(0,1.08fr) minmax(300px,.92fr);gap:16px;align-items:start}#property-map{height:540px;min-height:360px;border-radius:16px;overflow:hidden;border:1px solid var(--line);background:#10243b}
        .map-caption{color:var(--muted);font-size:.78rem;margin:8px 2px 0}.cards{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}.card{background:var(--panel);border:1px solid var(--line);border-radius:14px;overflow:hidden;min-width:0}
        .card-body{padding:14px}.placeholder{height:135px;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#102b49,#0b1a2d);color:#7fa9d9;font-size:2rem}
        .card h3{font-size:1rem;line-height:1.3;margin:0 0 6px}.card h3 a{text-decoration:none}.price{font-weight:850;font-size:1.08rem;margin:10px 0 2px}
        .pill{display:inline-block;color:#bfdbfe;background:#18375a;border:1px solid #31577f;border-radius:999px;padding:3px 8px;font-size:.72rem}
        .empty{border:1px dashed #3a5270;border-radius:16px;padding:28px;text-align:center;background:rgba(14,32,56,.5)}.notice{border-left:3px solid var(--blue2);background:#0d223b;color:#dbeafe;padding:12px 15px;border-radius:0 9px 9px 0;font-size:.85rem;margin:22px 0}
        .pagination{margin:20px 0;display:flex;flex-wrap:wrap;gap:8px}.pagination a,.pagination span{padding:7px 11px;border:1px solid var(--line);border-radius:8px;text-decoration:none}
        footer{border-top:1px solid var(--line);margin-top:42px;padding:24px 0 36px;color:#8297b2;font-size:.85rem}.detail-grid{display:grid;grid-template-columns:1.2fr .8fr;gap:20px;margin-top:26px}.detail-panel{border:1px solid var(--line);background:var(--panel);padding:20px;border-radius:16px}
        .facts{display:grid;grid-template-columns:1fr 1fr;gap:12px}.fact{padding:12px;background:#091a2d;border:1px solid #203a57;border-radius:10px}.fact small{display:block;color:var(--muted)}
        @media(max-width:980px){.search{grid-template-columns:repeat(3,minmax(0,1fr))}.market-grid{grid-template-columns:1fr}#property-map{height:380px}}
        @media(max-width:600px){.container{width:calc(100% - 22px)}.nav-note{display:none}.search{grid-template-columns:1fr 1fr}.search .wide{grid-column:1/-1}.cards{grid-template-columns:1fr}.detail-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
<header class="topbar"><div class="container nav">
    <a class="brand" href="{{ route('home') }}">PlotPoint <span>Tanzania</span></a>
    <span class="nav-note">Find Your Plot. Know Its Location. Make Your Move.</span>
    <span class="pill">Early access build</span>
</div></header>
<main class="container">@yield('content')</main>
<footer><div class="container"><strong>PlotPoint Tanzania</strong> · Location-first land discovery.
<p>Map locations are approximate discovery aids, not proof of ownership, title, or surveyed boundaries. Complete independent legal and land-document checks before paying.</p></div></footer>
@stack('scripts')
</body>
</html>
