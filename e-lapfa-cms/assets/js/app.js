// UI helpers
document.addEventListener('DOMContentLoaded', function(){
  // auth tabs
  var btnLogin = document.getElementById('btnLogin'), btnReg = document.getElementById('btnReg');
  if(btnLogin){
    btnLogin.addEventListener('click', function(){ document.getElementById('loginForm').style.display='block'; document.getElementById('regForm').style.display='none'; btnLogin.classList.add('active'); btnReg.classList.remove('active'); });
    btnReg.addEventListener('click', function(){ document.getElementById('loginForm').style.display='none'; document.getElementById('regForm').style.display='block'; btnReg.classList.add('active'); btnLogin.classList.remove('active'); });
  }

  // theme
  var select = document.getElementById('themeSelect');
  function applyTheme(t){
    if(t === 'dark') document.documentElement.setAttribute('data-theme','dark');
    else document.documentElement.removeAttribute('data-theme');
    localStorage.setItem('e_lapfa_theme', t);
  }
  if(select){
    select.value = localStorage.getItem('e_lapfa_theme') || 'light';
    applyTheme(select.value);
    select.addEventListener('change', function(){ applyTheme(this.value); });
  }
});
