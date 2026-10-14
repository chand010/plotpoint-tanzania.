<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Find land in Tanzania with location-first property discovery.">
    <title>PlotPoint Tanzania</title>
    <style>
        :root { color-scheme: dark; --navy: #071426; --panel: #0e2038; --blue: #3b82f6; --text: #f8fafc; --muted: #a8b8cc; }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; background: radial-gradient(ellipse at top right, #12396b 0, var(--navy) 48%); color: var(--text); font: 16px/1.6 system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        main { width: min(1080px, calc(100% - 32px)); margin: 0 auto; padding: 28px 0 64px; }
        nav { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 10px 0 56px; }
        .brand { font-weight: 800; letter-spacing: -.04em; font-size: 1.2rem; }
        .brand span { color: #60a5fa; }
        .badge { border: 1px solid #315276; border-radius: 999px; color: #bfdbfe; padding: 6px 12px; font-size: .8rem; }
        .hero { max-width: 760px; padding: 36px 0 48px; }
        h1 { font-size: clamp(2.6rem, 8vw, 5rem); line-height: 1.04; letter-spacing: -.055em; margin: 18px 0; }
        h1 span { color: #60a5fa; }
        p { color: var(--muted); font-size: 1.08rem; max-width: 660px; }
        .actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 28px; }
        .button { display: inline-block; border-radius: 10px; padding: 12px 18px; text-decoration: none; font-weight: 700; }
        .primary { background: var(--blue); color: white; }
        .secondary { border: 1px solid #38516f; color: white; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-top: 28px; }
        .card { border: 1px solid #233d5d; background: rgba(14,32,56,.82); padding: 20px; border-radius: 16px; }
        .card h2 { font-size: 1rem; margin: 0 0 8px; }
        .card p { font-size: .94rem; margin: 0; }
        .notice { border-left: 3px solid #60a5fa; margin-top: 26px; padding: 12px 16px; background: rgba(30,64,110,.25); color: #dbeafe; font-size: .9rem; }
        footer { color: #8297b2; border-top: 1px solid #203651; margin-top: 44px; padding-top: 20px; font-size: .85rem; }
    </style>
</head>
<body>
<main>
    <nav aria-label="Main navigation">
        <div class="brand">PlotPoint <span>Tanzania</span></div>
        <div class="badge">Early build · Not a live marketplace</div>
    </nav>
    <section class="hero">
        <div class="badge">Location-first land discovery</div>
        <h1>Find Your Plot.<br><span>Know Its Location.</span><br>Make Your Move.</h1>
        <p>PlotPoint is being built to help people discover land in Tanzania with clearer location information, useful listing details, and safer enquiry workflows.</p>
        <div class="actions">
            <a class="button primary" href="#how-it-works">Explore the plan</a>
            <a class="button secondary" href="https://github.com/chand010/plotpoint-tanzania.">View project source</a>
        </div>
    </section>
    <section id="how-it-works" class="grid" aria-label="Project principles">
        <article class="card"><h2>📍 Location first</h2><p>Map-based discovery is planned so visitors can understand the general area before enquiring.</p></article>
        <article class="card"><h2>🧾 Clear listing details</h2><p>Future listings should show plot size, price, status, available documents, and the source of the information.</p></article>
        <article class="card"><h2>🛡️ Safer enquiries</h2><p>Seller checks and property-document review are separate steps; a map pin alone never proves ownership or boundaries.</p></article>
    </section>
    <div class="notice"><strong>Development notice:</strong> This is an early Laravel foundation page. It has no real listings, authentication, enquiry handling, map integration, or document uploads yet. Do not use it to make a land purchase decision.</div>
    <footer>© {{ date('Y') }} PlotPoint Tanzania · Find Your Plot. Know Its Location. Make Your Move.</footer>
</main>
</body>
</html>
