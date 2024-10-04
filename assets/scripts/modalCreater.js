class Modal {
    constructor(buttonClass, modalContent) {
        this.buttonClass = buttonClass;
        this.modalContent = modalContent;
        this.modal = null;
        this.init();
    }

    init() {
        document.querySelectorAll(`.${this.buttonClass}`).forEach(button => {
            button.addEventListener('click', () => this.openModal());
        });
    }

    openModal() {
        if (this.modal) return;

        this.modal = document.createElement('div');
        this.modal.classList.add('modal');
        this.modal.innerHTML = `
            <div class="modal-overlay"></div>
            <div class="modal-content">
                ${this.modalContent}
                <button class="modal-close">X</button>
            </div>
        `;
        document.body.appendChild(this.modal);

        this.modal.querySelector('.modal-overlay').addEventListener('click', () => this.closeModal());
        this.modal.querySelector('.modal-close').addEventListener('click', () => this.closeModal());

        if (typeof this.populateChats === 'function') {
            this.populateChats();
        }
    }

    closeModal() {
        if (this.modal) {
            document.body.removeChild(this.modal);
            this.modal = null;
        }
    }


    populateChats() {
        const chatsWrap = document.querySelector('.chats-wrap');
        chatsWrap.innerHTML = '';

        if (userChats && userChats.length > 0) {
            userChats.forEach(chat => {
                const chatElement = document.createElement('div');
                chatElement.classList.add('chat-item');
                chatElement.innerHTML = `
                    <p><strong>${chat.chat_name}</strong></p>
                    <p>Приватный: ${chat.private_chat ? 'Да' : 'Нет'}</p>
                `;
                chatsWrap.appendChild(chatElement);
            });
        } else {
            chatsWrap.innerHTML = '<p>Чатов пока нет.</p>';
        }
    }
}


document.addEventListener('DOMContentLoaded', () => {


    const modalContentCreateChat = `
        
        <div class="wrap-chat-create">
                <form id="createChatForm" action="/controller/chats/CreateChat.php" method="POST">
                
                <div class="wrap-name-chat">
                    <label for="chat_name">Название чата:</label>
                    <input type="text" id="chat_name" name="chat_name" required>
                    <input type="hidden" id="user_ids" name="user_ids[]">
                </div>
                    
                    
                 <div class="wrap-private">
                    <label for="private_chat">Приватный чат:</label>
                    <input type="checkbox" id="private_chat" name="private_chat"> 
                </div>   
                   
                    
                    
                    
                    <div id="password_field" style="display: none; margin-left: -36px;"  ">
                        <label for="chat_password">Пароль:</label>
                        <input type="password" id="chat_password" name="chat_password">
                    </div>
                    
                    <button class="button-modal-create" type="submit">Создать чат</button>
        </form>
        </div>
        
    `;
    const modalCreateChat = new Modal('createChat', modalContentCreateChat);

    document.addEventListener('change', function(event) {
        if (event.target.id === 'private_chat') {
            const passwordField = document.getElementById('password_field');
            passwordField.style.display = event.target.checked ? 'block' : 'none';
        }
    });
});

