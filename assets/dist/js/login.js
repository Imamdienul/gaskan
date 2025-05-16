// capctha
const captcha = new Captcha($('#canvas'), {
  resourceType:'0'
})
$('#valid').on('click',function() {
  const ans = captcha.valid($('input[name="code"]').val());
  
  if (!ans) {
    $('#not-valid').text('Captcha tidak cocok')
    $('#lock').val(ans)
  } else {
    $('#not-valid').text('')
    $('#lock').val(ans)
  }
})

