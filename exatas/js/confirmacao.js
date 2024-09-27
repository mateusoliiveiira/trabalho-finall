document.addEventListener('DOMContentLoaded', function () {
    // Selecionar o modal e os botões
    const modal = document.getElementById('modal-confirm');
    const confirmBtn = document.getElementById('confirm-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    let deleteUrl = ''; // URL de exclusão

    // Selecionar todos os botões de excluir
    const deleteButtons = document.querySelectorAll('.delete-btn');

    // Quando o botão de excluir for clicado
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            deleteUrl = 'deletar_materia.php?id=' + this.getAttribute('data-id'); // Define a URL de exclusão
            modal.style.display = 'block'; // Mostrar o modal
        });
    });

    // Quando o botão de confirmar for clicado
    confirmBtn.addEventListener('click', function () {
        window.location.href = deleteUrl; // Redireciona para a página de exclusão
    });

    // Quando o botão de cancelar for clicado
    cancelBtn.addEventListener('click', function () {
        modal.style.display = 'none'; // Esconder o modal
    });

    // Fechar o modal ao clicar fora dele
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
});
