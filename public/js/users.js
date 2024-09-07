document
    .querySelector(".list-group-numbered")
    ?.addEventListener("click", (e) => {
        const userId = e.target.closest("li").dataset.id;
        const body = JSON.stringify({ userId });

        if (e.target.matches(".btn-cart, .btn-cart *")) {
            getUserProductsHandler(
                e.target.closest("li").nextElementSibling,
                body
            );
        } else if (e.target.matches(".btn-del, .btn-del *")) {
            deleteUserHandler(e.target.closest("li").nextElementSibling, body);
        }
    });

// попробовать зделать плавность отображения продукции пользователя
// const cbox = document.querySelector(".linkinp"),
//     tabs = document.querySelector("#tabs-section");
// cbox.addEventListener("change", (evt) => {
//     if (evt.target.checked)
//         tabs.scrollIntoView({ block: "start", behavior: "smooth" });
// });

function deleteUserHandler(elem, body) {
    fetch("deleteUser", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            credentials: "same-origin",
            "X-Requested-With": "XMLHttpRequest",
        },
        body: body,
    })
        .then((resp) => {
            if (!resp.ok) {
                throw new Error(
                    "Ошибка добавления визбранное. Попробуйте позже"
                );
            }
            return resp.json();
        })
        .then((data) => {
            if (data === false) {
                throw new Error(
                    "Ошибка добавления в корзину. Попробуйте позже"
                );
            } else {
                elem.previousElementSibling.remove();
                elem.remove();
                document.querySelector(".count-users").innerHTML =
                    document.querySelector(".count-users").innerHTML - 1;
            }
        })
        .catch((err) => {
            if (PROD) {
                alert(err);
            } else {
                console.error(err);
            }
        });
}

function getUserProductsHandler(elem, body) {
    fetch("getUserProducts", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            credentials: "same-origin",
            "X-Requested-With": "XMLHttpRequest",
        },
        body: body,
    })
        .then((resp) => {
            if (!resp.ok) {
                throw new Error(
                    "Ошибка добавления визбранное. Попробуйте позже"
                );
            }
            return resp.json();
        })
        .then((data) => {
            if (data === false) {
                throw new Error(
                    "Ошибка добавления в корзину. Попробуйте позже"
                );
            } else {
                if (Object.keys(data).length === 0) {
                    elem.innerHTML = "";
                    elem.insertAdjacentHTML(
                        "beforeend",
                        `<li class="list-group-item">Товары не добавлялись</li>`
                    );
                } else {
                    // console.log(data[0].name); // Black jacket
                    elem.innerHTML = "";
                    renderProducts(elem, data);
                }
            }
        })
        .catch((err) => {
            if (PROD) {
                alert(err);
            } else {
                console.error(err);
            }
        });
}

function renderProducts(elem, data) {
    let i = 1;
    let output = `
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Имя</th>
            <th scope="col">Цена</th>
            <th scope="col">Колличество</th>
            <th scope="col">Общая цена</th>
        </tr>
    </thead>
    <tbody class="tbodyUserProducts">
    `;

    Object.values(data).forEach((product) => {
        output += `
        <tr>
            <th scope="row">${i}</th>
            <td>${product.name}</td>
            <td>$${product.price}</td>
            <td>${product.qty}</td>
            <td>$${product.price * product.qty}</td>
        </tr>
        `;
        i++;
    });
    output += `</tbody>`;

    elem.insertAdjacentHTML("beforeend", output);
}

/*
            <li class="list-group-item">
            <b>Name: </b>${product.name} &ensp;
            <b>Price: </b> $${product.price} &ensp;
            <b>Count: </b> ${product.qty} &ensp;
            </li>

            <table class="table table-dark table-striped-columns">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Имя</th>
            <th scope="col">Цена</th>
            <th scope="col">Колличество</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">1</th>
            <td>${product.name}</td>
            <td>$${product.price}</td>
            <td>${product.qty}</td>
        </tr>
    </tbody>
</table>;
*/
