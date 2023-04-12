<?php
echo '
    <div class="container-fluid position-relative mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control" id="user-seach-input" placeholder="Zadej jméno hledaného uživatele">
            <div class="position-absolute" id="search-results-box">
                <div class="list-group" id="list-group">
                </div>
            </div>
        </div>
    </div>
';
?>

<script>
    /*
     Funkce zajišťující prodlevu mezi zadáváním uživatele a vyhledáváním seriálu.
     Při každém stisknutí tlačítka se doba resetuje, a tak se snižuje počet poslaných requestů.
     */
    function debounce(func, timeout = 300){
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => { func.apply(this, args); }, timeout);
        };
    }

    window.addEventListener("DOMContentLoaded", () => {
        const userSearchInput = document.getElementById("user-seach-input");
        const userSearchResults = document.getElementById("search-results-box");

        userSearchInput.addEventListener("input", debounce(async (event) => {
            const queryString = event.target.value;

            const res = await fetch('/api/user-search.php?queryString=' + queryString);
            const data = await res.json();
            console.log(data);

            const listGroupOld = document.getElementById("list-group");
            if (listGroupOld) {
                userSearchResults.removeChild(listGroupOld);
            }

            if (data) {
                const listGroup = document.createElement("div");
                listGroup.classList.add("list-group");
                listGroup.setAttribute("id", "list-group");

                data.forEach(user => {
                    const userResultLink = document.createElement("a");
                    userResultLink.classList.add("list-group-item", "list-group-item-action");
                    userResultLink.setAttribute("href", "user.php?id=" + user["id"]);

                    const userResultBox = document.createElement("div");
                    userResultBox.classList.add("w-100");

                    const userResultTitle = document.createElement("h6");
                    userResultTitle.classList.add("mb-1");
                    userResultTitle.innerText = user["full_name"] + ' (@' + user["user_name"] + ')';

                    userResultBox.appendChild(userResultTitle);
                    userResultLink.appendChild(userResultBox);
                    listGroup.appendChild(userResultLink);
                });
                userSearchResults.appendChild(listGroup);
            }
        }));
    });
</script>
