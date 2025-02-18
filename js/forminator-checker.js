const observerConfig = {
    childList: true,
    subtree: true
};

const observer = new MutationObserver((mutations, obs) => {
    const form = document.querySelector('#forminator-module-15665');
    
    if (form) {
        console.log('Formulaire 15665 détecté et chargé');
        obs.disconnect();
        
        const maxChecked = 3;
        const checkboxSelectors = Array.from({length: 10}, (_, i) => `input[name="checkbox-${i + 1}[]"]`);
        const allCheckboxes = form.querySelectorAll(checkboxSelectors.join(','));
        
        console.log('Nombre de checkbox trouvées:', allCheckboxes.length);
        
        allCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkboxLabel = this.closest('label').querySelector('.forminator-checkbox-label').textContent;
                const checkboxNumber = this.name.match(/checkbox-(\d+)/)[1];
                const totalChecked = Array.from(allCheckboxes).filter(cb => cb.checked).length;
                
                console.log('=== Changement détecté ===');
                console.log('Numéro de checkbox:', checkboxNumber);
                console.log('Label:', checkboxLabel);
                console.log('Valeur:', this.value);
                console.log('État:', this.checked ? 'Cochée' : 'Décochée');
                console.log('Total cochées:', totalChecked);
                
                if (this.checked && totalChecked > maxChecked) {
                    this.checked = false;
                    this.closest('label').classList.remove('forminator-is-checked');
                    alert(`Vous ne pouvez sélectionner que ${maxChecked} postes maximum`);
                    return;
                }
                
                if (this.checked) {
                    this.closest('label').classList.add('forminator-is-checked');
                } else {
                    this.closest('label').classList.remove('forminator-is-checked');
                }
                
                // Gestion des checkbox restantes
                allCheckboxes.forEach(cb => {
                    if (!cb.checked) {
                        if (totalChecked >= maxChecked) {
                            cb.disabled = true;
                            cb.closest('label').classList.add('forminator-checkbox-disabled');
                        } else {
                            cb.disabled = false;
                            cb.closest('label').classList.remove('forminator-checkbox-disabled');
                        }
                    }
                });
                
                console.log('Cases restantes disponibles:', maxChecked - totalChecked);
                console.log('========================');
            });
        });
    }
});

observer.observe(document.body, observerConfig);
