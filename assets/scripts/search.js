class Search {
    constructor(inputSelector, targetSelector, errorSelector) {
        this.input = document.querySelector(inputSelector);
        this.targets = document.querySelectorAll(targetSelector);
        this.error = document.querySelector(errorSelector);

        this.input.addEventListener('keyup', () => this.search());
    }

    search() {
        const filter = this.input.value.toLowerCase();
        let found = false;

        this.targets.forEach(target => {
            const text = target.querySelector('p:nth-child(2)').textContent.toLowerCase();
            if (text.includes(filter)) {
                target.classList.remove('hidden');
                found = true;
            } else {
                target.classList.add('hidden');
            }
        });

        if (found) {
            this.error.classList.add('hidden');
        } else {
            this.error.classList.remove('hidden');
        }
    }
}


const searchChats = new Search('.search-chats', '.chat', '.error');
