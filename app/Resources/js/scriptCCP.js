let modal = document.getElementById("myModal");

let btnDisplayModal = document.querySelectorAll(".modalbutton");

let span = document.getElementsByClassName("close")[0];

document.getElementById('modal-form').addEventListener("submit", function(event) {
      
    let select = document.getElementById('select_nota');
    let value = select.options[select.selectedIndex].value;
    if(value == 0) 
    {
        alert("Selecione um Parecer Válido");
        event.preventDefault();
    }
    
});

document.getElementById('input-lote').addEventListener('click', function(event) {
      
    let select = document.getElementById('select_nota');

    let comment = document.getElementById('comentario');

    let parecerOrientador = document.querySelector('.nota > p');

    let commentOrientador = document.querySelector('.comment-prof > div > p');


    if(parecerOrientador.innerText == "ADEQUADO") select.selectedIndex = "1";
    else if (parecerOrientador.innerText == "ADEQUADO COM RESSALVAS") select.selectedIndex = "2";
    else select.selectedIndex = "3";

    comment.innerText = commentOrientador.innerText;
    
    document.querySelector('.lote').style.display = "none";
});

function fileNameString(path){
    let fileNameString = path.innerText.split(/(\\|\/)/g).pop()

    if(fileNameString.length > 40){
        fileNameString = fileNameString.substring(0,40)+'...'
    }
    path.innerText = fileNameString;
}

function fillModal(id){
             $.ajax({
                url:"app/Ajax/modalCCP.php",    //the page containing php script
                type: "post",    //request type,
                dataType: 'json',
                data: {id_rel: id},
                success:function(result){
                    /*console.log(result.id_aval);
                    console.log(result.caminho);
                    console.log(result.comment_aluno);
                    console.log(result.nome_prof);
                    console.log(result.nota_prof);
                    console.log(result.comment_prof);
                    console.log(result.nota_cpp);
                    console.log(result.comment_cpp);*/

                    $('#id_aval').val(result.id_aval);

                    $('.file > a').attr("href", result.caminho)
                    $('.file > a > p').text(result.caminho)
                    let caminhoParagraph = document.querySelector('.file > a > p');
                    fileNameString(caminhoParagraph);

                    $('.nome-prof > p').text(result.nome_prof);

                    if(result.comment_aluno == null) $('.comentario-aluno').hide();
                    else 
                    {
                        $('.comentario-aluno').show();
                        $('.comentario-aluno > p').text(result.comment_aluno)
                    }

                    $('.nota > p').text(result.nota_prof);
                    $('.comment-prof > div > p').text(result.comment_prof);

                    if(result.nota_cpp == "ADEQUADO") $('#select_nota').val('1');
                    else if (result.nota_cpp == "ADEQUADO COM RESSALVAS") $('#select_nota').val('2');
                    else if (result.nota_cpp == "INSATISFATÓRIO") $('#select_nota').val('3');
                    else $('#select_nota').val('0');
                    
                    $('#comentario').text(result.comment_cpp)

                    if( (document.querySelector('#select_nota').selectedIndex == 0) && ( document.querySelector('#comentario').innerText == "")) {
                        let lotebox = document.querySelector('.lote');
                        lotebox.style.display = "flex";
                        document.querySelector('#input-lote').checked = false;
                    }
                }
            });
}

function clickDisplayModal(event) {
    modal.style.display = "block";
    document.querySelector('.lote').style.display = "none";
    let p = ((event.target).children[2]);
    if(p == undefined) p = ((event.target).parentElement).children[2];

    fillModal(p.innerText);
}

btnDisplayModal.forEach(button => {
    button.addEventListener('click', clickDisplayModal)
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