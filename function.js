// Função para atualizar campos editáveis
function atualizarCampo(elemento, campo, id) {
    const valor = elemento.innerText.trim();

    fetch('atualizar_campo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}&campo=${campo}&valor=${encodeURIComponent(valor)}`
    })
    .then(res => res.text())
    .then(data => {
        exibirMensagem(data, true);
    })
    .catch(err => {
        console.error('Erro:', err);
        exibirMensagem('Erro ao atualizar campo.', false);
    });
}

// Função para exibir mensagens de sucesso/erro
function exibirMensagem(texto, sucesso = true) {
    const div = document.getElementById('mensagem');
    div.textContent = texto;
    div.style.color = sucesso ? 'green' : 'red';
    div.style.fontWeight = 'bold';

    // Some após 3 segundos
    setTimeout(() => {
        div.textContent = '';
    }, 3000);
}

// Função para atualizar imagem de perfil
function atualizarImagem(event, id) {
    const file = event.target.files[0];
    
    // Verifica se há um arquivo selecionado
    if (file) {
        const formData = new FormData();
        formData.append('id', id);
        formData.append('imagem_perfil', file);
        
        // Envia o arquivo via AJAX
        fetch('atualizar_imagem.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Atualiza a imagem na página
                document.getElementById('img_perfil').src = data.imagem_perfil;
                alert('Imagem de perfil atualizada com sucesso!');
            } else {
                alert('Erro ao atualizar imagem.');
            }
        })
        .catch(err => {
            console.error('Erro:', err);
            alert('Erro ao enviar a imagem.');
        });
    }
}

//Função para alterar a senha
function mostrarCampoSenha() {
    document.getElementById("senhaContainer").style.display = "block";
}

function alterarSenha(id) {
    const senhaAtual = document.getElementById("senhaAtual").value;
    const novaSenha = document.getElementById("novaSenha").value;

    if (!senhaAtual || !novaSenha) {
        alert("Preencha os dois campos.");
        return;
    }

    fetch("atualizar_senha.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id=${id}&senhaAtual=${encodeURIComponent(senhaAtual)}&novaSenha=${encodeURIComponent(novaSenha)}`
    })
    .then(res => res.text())
    .then(resposta => {
        alert(resposta);
        document.getElementById("senhaContainer").style.display = "none";
        document.getElementById("senhaAtual").value = "";
        document.getElementById("novaSenha").value = "";
    })
    .catch(err => {
        console.error("Erro ao atualizar senha:", err);
        alert("Erro ao atualizar senha.");
    });
}
