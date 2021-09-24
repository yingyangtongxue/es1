let modal = document.getElementById("myModal");

let btn = document.querySelectorAll(".modalbutton");

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


function fillModal(id){
    let values = $.ajax({
                url:"app/Ajax/modalOrientador.php",    //the page containing php script
                type: "post",    //request type,
                dataType: 'json',
                data: {id_rel: id},
                success:function(result){
                    console.log(result.caminho);
                    console.log(result.nota);
                    console.log(result.comment_aluno);
                    console.log(result.comment_prof);

                    $('.file > a').attr("href", result.caminho)
                    $('.file > a > p').text(result.caminho)

                    if(result.comment_aluno == null) $('.comentario-aluno').hide();
                    else 
                    {
                        $('.comentario-aluno').show();
                        $('.comentario-aluno > p').text(result.comment_aluno)
                    }

                    if(result.nota == "ADEQUADO") $('#select_nota').val('1');
                    if (result.nota == "ADEQUADO COM RESSALVAS") $('#select_nota').val('2');
                    else if (result.nota == "INSATISFATÓRIO") $('#select_nota').val('3');
                    else $('#select_nota').val('0');
                    
                    $('#comentario').text(result.comment_prof)
                }
            });
    console.log(values);
}

function clickModal(event) {
    modal.style.display = "block";
    let p = ((event.target).children[2]);
    if(p == undefined) p = ((event.target).parentElement).children[2];

    console.log(p);
    fillModal(p.innerHTML);
}

btn.forEach(button => {
    button.addEventListener('click', clickModal)
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