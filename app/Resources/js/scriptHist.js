let modal = document.getElementById("myModal");

let btnDisplayModal = document.querySelectorAll(".modalbutton");

let span = document.getElementsByClassName("close")[0];

function fileNameString(path){
    let fileNameString = path.innerText.split(/(\\|\/)/g).pop()

    if(fileNameString.length > 40){
        fileNameString = fileNameString.substring(0,40)+'...'
    }
    path.innerText = fileNameString;
}

function fillModal(id){
             $.ajax({
                url:"app/Ajax/modalHist.php",    //the page containing php script
                type: "post",    //request type,
                dataType: 'json',
                data: {id_rel: id},
                success:function(result){
                    console.log(result.caminho);
                    console.log(result.dataInicio);
                    console.log(result.dataTermino);
                    console.log(result.comment_aluno);
                    console.log(result.nota_prof);
                    console.log(result.comment_prof);
                    console.log(result.nota_cpp);
                    console.log(result.comment_cpp);


                    $('.file > a').attr("href", result.caminho);
                    $('.file > a > p').text(result.caminho);
                    let caminhoParagraph = document.querySelector('.file > a > p');
                    fileNameString(caminhoParagraph);

                    let inicio = new Date(result.dataInicio);
                    let termino = new Date(result.dataTermino);
                    $('.periodo > p').text(inicio.toLocaleDateString("pt-BR")+" - "+termino.toLocaleDateString("pt-BR"));

                    if(result.comment_aluno == null) $('.comentario-aluno').hide();
                    else 
                    {
                        $('.comentario-aluno').show();
                        $('.comentario-aluno > p').text(result.comment_aluno);
                    }
                    
                    
                    if(result.nota_prof == null) $('.nota > p').text("NÃO AVALIADO");
                    else $('.nota > p').text(result.nota_prof);
                    if(result.comment_prof == null) $('.comment-prof > div > p').text("NÃO AVALIADO");
                    else $('.comment-prof > div > p').text(result.comment_prof);

                    if(result.nota_cpp == null) $('.nota-ccp > p').text("NÃO AVALIADO");
                    else $('.nota-ccp > p').text(result.nota_cpp);
                    if(result.comment_cpp == null) $('.comment-ccp > div > p').text("NÃO AVALIADO")
                    else $('.comment-ccp > div > p').text(result.comment_cpp)
                }
            });
}

function clickDisplayModal(event) {
    modal.style.display = "block";
    let p = ((event.target).children[2]);
    if(p == undefined) p = ((event.target).parentElement).children[2];

    console.log(p.innerText);
    fillModal(p.innerText);
}

btnDisplayModal.forEach(button => {
    button.addEventListener('click',clickDisplayModal)
})
span.onclick = function () {
    modal.style.display = "none";
}

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}


/*let btnRelatorio = document.querySelector("#novo-relatorio")

btnRelatorio.addEventListener('click', () =>{
    let item = document.createElement('li')
    let buttonModal = document.createElement('p')
    buttonModal.classList.add('modalbutton')
    item.appendChild(buttonModal)
})
*/