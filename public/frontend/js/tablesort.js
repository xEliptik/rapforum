function sortTableByColumn(table, column, asc = true) {
    const dirModifier = asc ? 1 : -1;
    const tBody = table.tBodies[0];
    const rows = Array.from(tBody.querySelectorAll("tr"));

    // Obtener la función de comparación adecuada para la columna
    const compareFn = getCompareFunctionForColumn(column);

    // Sortear las filas utilizando la función de comparación personalizada
    const sortedRows = rows.sort((a, b) => {
        const aColText = a.querySelector(`td:nth-child(${column + 1})`).textContent.trim();
        const bColText = b.querySelector(`td:nth-child(${column + 1})`).textContent.trim();
        return compareFn(aColText, bColText) * dirModifier;
    });

    // Restaurar las filas ordenadas en la tabla
    while (tBody.firstChild) {
        tBody.removeChild(tBody.firstChild);
    }
    tBody.append(...sortedRows);

    // Aplicar las clases CSS de orden ascendente/descendente al encabezado seleccionado
    table.querySelectorAll("th").forEach(th => th.classList.remove("th-sort-asc", "th-sort-desc"));
    table.querySelector(`th:nth-child(${column + 1})`).classList.toggle("th-sort-asc", asc);
    table.querySelector(`th:nth-child(${column + 1})`).classList.toggle("th-sort-desc", !asc);
}

function getCompareFunctionForColumn(column) {
    // Asignar una función de comparación adecuada para cada columna
    switch (column) {
        case 0: // Columna de imagen
        case 7: // Columna de enlace
            return () => 0; // No realizar ningún ordenamiento para estas columnas
        case 1: // Columna de posición (numérica)
        case 5: // Columna de mejor posición (numérica)
        case 6: // Columna de semanas en el top (numérica)
            return (a, b) => parseInt(a) - parseInt(b); // Ordenar como números enteros
        case 4: // Columna de semana pasada (numérica con guiones)
            return (a, b) => {
                if (a === '-') {
                    return 1; // Mover los guiones al final
                } else if (b === '-') {
                    return -1; // Mover los guiones al final
                } else {
                    return parseInt(a) - parseInt(b); // Ordenar como números enteros
                }
            };
        default: // Resto de columnas (texto)
            return (a, b) => a.localeCompare(b); // Ordenar como texto
    }
}

document.querySelectorAll(".table-sortable th").forEach(headerCell => {
    headerCell.addEventListener("click", () => {
        const tableElement = headerCell.parentElement.parentElement.parentElement;
        const headerIndex = Array.prototype.indexOf.call(headerCell.parentElement.children, headerCell);
        const currentIsAscending = headerCell.classList.contains("th-sort-asc");

        sortTableByColumn(tableElement, headerIndex, !currentIsAscending);
    });
});
