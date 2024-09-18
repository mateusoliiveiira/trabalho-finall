const headers = document.querySelectorAll('.accordion-header');

headers.forEach(header => {
  header.addEventListener('click', () => {
    const content = header.nextElementSibling;
    
    // Fechar outros conteúdos abertos
    const openItems = document.querySelectorAll('.accordion-content');
    openItems.forEach(item => {
      if (item !== content) {
        item.style.maxHeight = null;
      }
    });

    // Alternar o conteúdo atual
    if (content.style.maxHeight) {
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    }
  });
});
