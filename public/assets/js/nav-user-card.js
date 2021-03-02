const navUserCard = () => {
    const nav_greeting = document.getElementById('nav-greeting');
    const nav_user_card = document.getElementById('nav-user-card');
    
    let state = false;
    const changeState = () => {
        if (state) {
            nav_user_card.classList.add("hidden");
            state = false;
        }
        else {
            nav_user_card.classList.remove("hidden");
            state = true;
        }
    }

    nav_greeting.addEventListener("click", changeState);
}

window.addEventListener("load", navUserCard);