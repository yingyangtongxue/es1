var $input    = document.getElementById('upload-pdf'),
    $fileName = document.getElementById('file-name');

$input.addEventListener('change', function(){
    
  if(this.value === "" || this.value === null){
    $fileName.innerHTML = "<i class='fas fa-plus' style='margin-right:0.4rem;margin-top: 0.1rem;'></i>" + "Adicionar Relatório"
    $fileName.title = "Adicionar Relatório"
  }
  else{
    let fileNameString = this.value.split(/(\\|\/)/g).pop()
    $fileName.title = fileNameString
    if(fileNameString.length > 30){
        fileNameString = fileNameString.substring(0,30)+'...'
    }
    $fileName.innerHTML = "<i class='fas fa-paperclip' style='margin-right:0.4rem;'></i>" +  fileNameString
  }
});