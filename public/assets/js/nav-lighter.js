const main = () => {
    const full_path_name = window.location.pathname;
    const splited_path_name = full_path_name.split('/');
    splited_path_name.shift();

    const home = document.getElementById('nav-home');
    const getting_started = document.getElementById('nav-getting-started');
    const credits = document.getElementById('nav-credits');
    const login = document.getElementById('nav-login');
    const register = document.getElementById('nav-register');
    const project_list = document.getElementById('nav-project-list');
    const project_create = document.getElementById('nav-project-create');

    switch (splited_path_name[0]) {
        case "":
            home.classList.add('selected');
            break;
        case "getting-started":
            getting_started.classList.add('selected');
            break;
        case "credits":
            credits.classList.add('selected');
            break;
        case "user":
            if (splited_path_name[1] === 'login')
                login.classList.add('selected');
            else if (splited_path_name[1] === 'register')
                register.classList.add('selected');
            break;
        case "project":
            if (splited_path_name[1] === 'new')
                project_create.classList.add('selected');
            else
                project_list.classList.add('selected');
            break;
    }
}

window.addEventListener("load", main);