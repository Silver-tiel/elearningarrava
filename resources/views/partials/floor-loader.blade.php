{{-- Loading layar penuh saat naik lantai. Pakai: @include('partials.floor-loader') lalu FloorLoader.show({from:1,to:2,duration:3200,onDone:(to)=>{...}}) --}}
<style>
.fl{--px:3;position:fixed;inset:0;z-index:9999;display:none;flex-direction:column;align-items:center;justify-content:center;padding:max(24px,env(safe-area-inset-top,0px)) 20px max(24px,env(safe-area-inset-bottom,0px));background:rgba(3,10,20,.84);backdrop-filter:blur(3px);-webkit-backdrop-filter:blur(3px);color:#fff;font-family:"Nunito",system-ui,sans-serif;font-weight:700;opacity:1;transition:opacity .5s}
.fl.show{display:flex}
.fl.hide{opacity:0}
.fl-box{width:min(100%,420px);text-align:center}
.fl-title{margin:0;font-family:"Fredoka","Nunito",system-ui,sans-serif;font-size:30px;line-height:1.15;font-weight:700;text-shadow:0 3px 0 #0f3a5f}
.fl-from{margin:6px 0 0;font-size:14px;color:#a9d6f5}
.fl-stage{position:relative;width:100%;height:calc(67px * var(--px));margin-top:18px}
.fl-runner{position:absolute;left:0;bottom:0;display:block;width:calc(71px * var(--px));height:calc(67px * var(--px));image-rendering:pixelated;will-change:transform;transition:left .25s linear,transform .25s linear}
.fl-bar{display:flex;gap:3px;height:38px;margin-top:2px;padding:4px;background:#0a2237;border:4px solid #cfe9fb;clip-path:polygon(0 4px,4px 4px,4px 0,calc(100% - 4px) 0,calc(100% - 4px) 4px,100% 4px,100% calc(100% - 4px),calc(100% - 4px) calc(100% - 4px),calc(100% - 4px) 100%,4px 100%,4px calc(100% - 4px),0 calc(100% - 4px))}
.fl-bar i{flex:1;background:#16405f;box-shadow:inset 0 3px 0 rgba(255,255,255,.07)}
.fl-bar i.on{background:#38bdf8;box-shadow:inset 0 4px 0 #bae6fd,inset 0 -4px 0 #0ea5e9}
.fl.done .fl-bar i.on{background:#34d399;box-shadow:inset 0 4px 0 #a7f3d0,inset 0 -4px 0 #10b981}
.fl-row{display:flex;justify-content:space-between;align-items:baseline;gap:12px;margin-top:12px;font-size:14px;color:#cfe9fb}
.fl-pct{font-family:"Fredoka",sans-serif;font-size:22px;font-weight:600;color:#fff;font-variant-numeric:tabular-nums}
@media (max-width:400px){.fl{--px:2}.fl-title{font-size:26px}}
</style>

<div class="fl" id="fl" role="dialog" aria-modal="true" aria-label="Memuat lantai berikutnya">
  <div class="fl-box">
    <h2 class="fl-title" id="flTitle">Naik ke Lantai 2</h2>
    <p class="fl-from" id="flFrom">Dari Lantai 1</p>
    <div class="fl-stage" aria-hidden="true">
      <img class="fl-runner" id="flRunner" src="{{ asset('images/run.gif') }}" alt="" width="71" height="67">
    </div>
    <div class="fl-bar" id="flBar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" aria-label="Memuat lantai"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div>
    <div class="fl-row"><span id="flMsg" role="status" aria-live="polite">Menyiapkan soal…</span><span class="fl-pct" id="flPct">0%</span></div>
  </div>
</div>

<script>
const FloorLoader=(()=>{
  const $=id=>document.getElementById(id);
  const MSG=["Menyiapkan soal…","Menaiki tangga…","Membuka pintu lantai…","Hampir sampai…"];
  let raf=0;
  function show({from=1,to=from+1,duration=3200,onDone}={}){
    const el=$("fl"),bar=$("flBar"),blocks=bar.children;
    cancelAnimationFrame(raf);
    const run=$("flRunner");
    run.style.left="0%";run.style.transform="translateX(0%)";
    el.classList.remove("hide","done");el.classList.add("show");
    document.documentElement.style.overflow="hidden";
    $("flTitle").textContent="Naik ke Lantai "+to;
    $("flFrom").textContent="Dari Lantai "+from;
    const t0=performance.now();
    function tick(now){
      let t=Math.min(1,(now-t0)/duration);
      let p=t<.9?(1-Math.pow(1-t/.9,1.6))*.92:.92+((t-.9)/.1)*.08;
      const pct=Math.floor(p*100);
      const n=Math.floor(p*blocks.length);for(let i=0;i<blocks.length;i++)blocks[i].classList.toggle("on",i<n);const snap=n/blocks.length*100;
      bar.setAttribute("aria-valuenow",pct);
      run.style.left=snap+"%";run.style.transform="translateX(-"+snap+"%)";
      $("flPct").textContent=pct+"%";
      $("flMsg").textContent=MSG[Math.min(MSG.length-1,Math.floor(t*MSG.length))];
      if(t<1){raf=requestAnimationFrame(tick)}else{finish()}
    }
    function finish(){
      el.classList.add("done");
      for(const b of blocks)b.classList.add("on");
      run.style.left="100%";run.style.transform="translateX(-100%)";
      $("flMsg").textContent="Lantai "+to+" siap!";
      setTimeout(()=>{
        el.classList.add("hide");
        setTimeout(()=>{el.classList.remove("show","hide");document.documentElement.style.overflow="";onDone&&onDone(to)},500);
      },700);
    }
    raf=requestAnimationFrame(tick);
  }
  return {show};
})();
window.FloorLoader = FloorLoader;
</script>
