document.addEventListener('trix-before-initialize', () => {
  if (!window.Trix) return;
  Trix.config.blockAttributes.heading1.tagName = 'h2';
  Object.assign(Trix.config.lang, {
    bold: 'Pogrubienie', italic: 'Kursywa', strike: 'Przekreślenie', link: 'Link',
    heading1: 'Nagłówek', quote: 'Cytat', code: 'Kod', bullets: 'Lista punktowana',
    numbers: 'Lista numerowana', outdent: 'Zmniejsz wcięcie', indent: 'Zwiększ wcięcie',
    undo: 'Cofnij', redo: 'Ponów', urlPlaceholder: 'Adres linku (https://...)',
    url: 'Adres linku', unlink: 'Usuń link', attachFiles: 'Dodaj pliki'
  });
});
document.addEventListener('trix-file-accept', event => event.preventDefault());
document.addEventListener('trix-initialize', event => {
  const editor = event.target;
  if (!editor.closest('.description-field')) return;
  editor.toolbarElement.querySelector('[data-trix-button-group="file-tools"]')?.remove();
  editor.toolbarElement.querySelector('[data-trix-dialog="href"] input')?.setAttribute('placeholder', 'https://...');
});
