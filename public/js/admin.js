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
                displayNewContentBySearch(body);
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
                        <button class="btn btn-secondary btn-sm" type="submit">Add</button>
                    </form>
                </li>
                <li class="nav-item d-grid col-12 mx-auto mt-2">
                    <form class="d-flex" id="del-category-form">
                        <select class="form-select form-select-sm me-2" id="select-all-category" name="category">
                            <option selected value="null">Null</option>
                        </select>
                        <button class="btn btn-secondary btn-sm" type="submit">Delete</button>
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

function displayNewContentBySearch(body) {
    fetch("displayNewContentBySearch", {
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
            //return resp.json();
            return resp.json();
        })
        .then((data) => {
            if (data === false) {
                throw new Error("Ошибка поиска. Попробуйте позже");
            } else {
                console.log(data[0]);
                let output = "<tr></tr>";
                let i = 1;
                // очистить прошлый вывод
                document
                    .getElementById("products-table")
                    .querySelector("tbody").innerHTML = "";
                // новый вывод
                data.forEach((value) => {
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
                                        ? value.price -
                                          (value.price / 100) * value.discount
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
        })
        .catch((err) => {
            if (PROD) {
                alert(err);
            } else {
                console.error(err);
            }
        });
}
