(function(){
  const rootId = 'toast-root';
  function ensureRoot(){
    let r = document.getElementById(rootId);
    if(!r){
      r = document.createElement('div');
      r.id = rootId;
      r.className = 'fixed z-50 inset-0 pointer-events-none flex flex-col items-end gap-3 p-4 sm:p-6';
      document.body.appendChild(r);
    }
    return r;
  }

  function makeToast(message, {type='info', timeout=3000}={}){
    const root = ensureRoot();
    const el = document.createElement('div');
    el.role = 'status';
    el.className = 'pointer-events-auto rounded-xl shadow-lg border px-4 py-3 max-w-sm w-full sm:w-auto ' + (
      type==='success' ? 'bg-green-50 text-green-800 border-green-200' :
      type==='error' ? 'bg-red-50 text-red-800 border-red-200' :
      type==='warning' ? 'bg-yellow-50 text-yellow-800 border-yellow-200' :
      'bg-blue-50 text-blue-800 border-blue-200'
    );
    el.textContent = message;
    root.appendChild(el);
    setTimeout(()=>{
      el.style.opacity = '0';
      el.style.transition = 'opacity 200ms ease';
      setTimeout(()=> el.remove(), 220);
    }, timeout);
  }

  window.toast = {
    success: (m,t=3000)=>makeToast(m,{type:'success',timeout:t}),
    error: (m,t=3000)=>makeToast(m,{type:'error',timeout:t}),
    warning: (m,t=3000)=>makeToast(m,{type:'warning',timeout:t}),
    info: (m,t=3000)=>makeToast(m,{type:'info',timeout:t}),
  };
})();
