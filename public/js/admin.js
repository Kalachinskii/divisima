const currentUrl = window.location.pathname;

if (currentUrl == "/admin/products") {
    // SERCH PRODUCTS
    // const arr = document
    //     .getElementById("products-table")
    //     ?.querySelectorAll(".name_product");

    // document.getElementById("search")?.addEventListener("input", (e) => {
    //     const value = e.target.value;

    //     arr.forEach((name) => {
    //         if (!name.textContent.trim().includes(value)) {
    //             name.closest("tr").classList.add("d-none");
    //         } else {
    //             name.closest("tr").classList.remove("d-none");
    //         }
    //     });
    // });

    // SERCH PRODUCTS BD
    document
        .getElementById("search-form")
        ?.querySelector("[type='submit']")
        .addEventListener("click", (e) => {
            e.preventDefault();
            const text = e.target.previousElementSibling.value.trim();
            if (text) {
                const body = JSON.stringify({
                    table: "products",
                    content: text,
                });
                console.log(body);
                getProductsBySearch(body);
            }
        });

    const output = ` <ul class="nav btn-products-grup">
                <li class="nav-item d-grid col-12 mb-2 mt-2 mx-auto">
                <button type="button" class="btn btn-secondary btn-sm btn-add-product" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="fa-solid fa-cart-plus"></i>
                    <span>&ensp;Add Product</span>
                </button>
                </li>
                <li class="nav-item d-grid col-12 mx-auto">
                    <form class="d-flex" id="add-category-form">
                        <input class="form-control-sm form-control me-2" type="search" placeholder="Add category" name="categorie">
                        <button class="btn btn-secondary btn-sm" type="submit"><i class="fa-solid fa-plus"></i></button>
                    </form>
                </li>
                <li class="nav-item d-grid col-12 mx-auto mt-2">
                    <form class="d-flex" id="del-category-form">
                        <select class="form-select form-select-sm me-2" id="select-all-category" name="category">
                            <option selected value="null">Null</option>
                        </select>
                        <button class="btn btn-secondary btn-sm" type="submit"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </li>
            </ul>`;
    document.getElementById("products-nav-item").classList.add("activ-btn");
    document
        .getElementById("products-nav-item")
        .insertAdjacentHTML("beforeend", output);
    alertElem =
        document.getElementById("products-nav-item").previousElementSibling;

    getAllCategory(alertElem);
} else if (currentUrl == "/admin/users") {
    document.getElementById("users-nav-item").classList.add("activ-btn");

    // SERCH USERS
    // const arr = document
    //     .getElementById("list-group")
    //     .querySelectorAll("#user-login-name");

    // document.getElementById("search").addEventListener("input", (e) => {
    //     const value = e.target.value;

    //     arr.forEach((name) => {
    //         if (!name.textContent.trim().includes(value)) {
    //             name.closest("li").classList.remove("d-flex");
    //             name.closest("li").classList.add("d-none");
    //         } else {
    //             name.closest("li").classList.add("d-flex");
    //             name.closest("li").classList.remove("d-none");
    //         }
    //     });
    // });

    // SERCH USERS BD
    document
        .getElementById("search-form")
        ?.querySelector("[type='submit']")
        .addEventListener("click", (e) => {
            e.preventDefault();
            const text = e.target.previousElementSibling.value.trim();
            if (text) {
                const body = JSON.stringify({
                    table: "users",
                    content: text,
                });
                console.log(body);
                getUsersBySearch(body);
            }
        });
}

function getAllCategory(alertElem) {
    fetch("getAllCategory")
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
                let options = ``;
                for (let i = 0; i < Object.keys(data).length; i++) {
                    options += `<option value='${data[i].id}'>${data[i].name}</option>`;
                }

                alertElem
                    .closest("ul")
                    .querySelector("select")
                    .insertAdjacentHTML("beforeend", options);
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

function getProductsBySearch(body) {
    fetch("getProductsBySearch", {
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
                throw new Error("Ошибка поиска. Попробуйте позже");
            }
            return resp.json();
        })
        .then((data) => {
            if (data === false) {
                throw new Error("Ошибка поиска. Попробуйте позже");
            } else {
                renderSearchProducts(data);
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

function getUsersBySearch(body) {
    fetch("getUsersBySearch", {
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
                throw new Error("Ошибка поиска. Попробуйте позже");
            }
            return resp.json();
        })
        .then((data) => {
            if (data === false) {
                throw new Error("Ошибка поиска. Попробуйте позже");
            } else {
                console.log(data);
                renderSearchUsers(data);
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

function renderSearchProducts(products) {
    let output = "";
    let i = 1;
    // очистить прошлый вывод
    document.getElementById("products-table").querySelector("tbody").innerHTML =
        "";
    // новый вывод
    products.forEach((value) => {
        output += `
            <tr data-id="${value.id}">
                <th scope="row">
                    ${i++}
                </th>
                <td>
                    <img src="/public/img/product/${
                        value.image
                    }" class="img-fluid rounded-start">
                </td>
                <td>
                    ${value.category_name}
                </td>
                <td class="name_product">
                ${value.name}
                </td>
                <td>
                    ${value.count}
                </td>
                <td>
                    ${value.price}
                </td>
                <td>
                    ${value.discount}
                </td>
                <td class="discounted-Price">
                    ${
                        value.discount > 0
                            ? value.price - (value.price / 100) * value.discount
                            : 0
                    }
                </td>
                <td>
                    ${value.hot}
                </td>
                <td>
                    <i class="fa-solid fa-pen-to-square" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> Изменить</i>
                </td>
                <td>
                    <i class="fa-solid fa-trash delete-btn"> Удалить</i>
                </td>
            </tr>
        `;
    });
    // отрисовка
    document
        .getElementById("products-table")
        .querySelector("tbody")
        .insertAdjacentHTML("beforeEnd", output);
}

function renderSearchUsers(users) {
    let output = "";
    // очистить прошлый вывод
    document.getElementById("list-group").innerHTML = "";
    // новый вывод
    users.forEach((value) => {
        output += `
                <li class="mb-1 mt-1 list-group-item d-flex justify-content-between align-items-center d-none" data-id="${
                    value.id
                }">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold" id="user-login-name">${
                            value.login
                        }</div>
                    </div>
                    <button type="button" class="btn-cart btn btn-primary mr-3" data-bs-toggle="collapse" href="#collapseExample${
                        value.id
                    }" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fa-solid fa-basket-shopping">
                            Корзина
                        </i>
                        <span class="badge bg-secondary">${
                            value.sum_products > 0 ? value.sum_products : 0
                        } </span>
                    </button>
                    <button type="button" class="btn btn-danger btn-del">
                        <i class="fa-solid fa-trash"> Удалить</i>
                    </button>
                </li>
                <table class="table table-striped-columns collapse ulExample${
                    value.id
                }" id="collapseExample${value.id}">
                </table>
        `;
    });
    // отрисовка
    document
        .getElementById("list-group")
        .insertAdjacentHTML("beforeEnd", output);
}
