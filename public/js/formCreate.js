let uniqueId = 0;

document.addEventListener("DOMContentLoaded", () => {
    const types = ['Short Answer', 'Long Answer', 'Multiple Choice', 'Checkbox', 'Dropdown', 'Time', 'Date'];
    const select = document.getElementById('inputType');
    types.forEach(type => {
        const opt = document.createElement('option');
        opt.value = opt.innerText = type;
        select.appendChild(opt);
    });
});

const renderConfig = () => {
    uniqueId++;
    const type = document.getElementById('inputType').value;
    const configDiv = document.getElementById('configDiv');

    // Create a new card for each appended input type
    const cardDiv = document.createElement('div');
    cardDiv.className = 'card-append';
    cardDiv.id = `card_${uniqueId}`;


    const dragHandle = document.createElement('span');
    dragHandle.innerHTML = '&#9776;'; // Unicode for a drag handle (triple-bar icon)
    dragHandle.style.float = 'right';
    dragHandle.style.cursor = 'grab';
    cardDiv.appendChild(dragHandle);

    // Create a delete icon
    const deleteIcon = document.createElement('span');
    deleteIcon.innerHTML = '&#10006;'; // Unicode for red "X" icon
    deleteIcon.style.float = 'right';
    deleteIcon.style.color = 'red';
    deleteIcon.style.cursor = 'pointer';
    deleteIcon.style.paddingRight = '4px';
    deleteIcon.onclick = () => {
        cardDiv.remove();
    };
    cardDiv.appendChild(deleteIcon);

    const sectionDiv = document.createElement('div');
    sectionDiv.id = `section_${uniqueId}`;
    sectionDiv.className = 'mb-4';

    const header = document.createElement('h5');
    header.innerText = `${type} Configuration`;
    sectionDiv.appendChild(header);

    if (['Multiple Choice', 'Checkbox', 'Dropdown'].includes(type)) {
        addTextConfig(sectionDiv, type).focus();
        addOptionConfig(sectionDiv, type);
    } else if (['Short Answer', 'Long Answer'].includes(type)) {
        addTextConfig(sectionDiv, type).focus();
    } else if (['Time', 'Date'].includes(type)) {
        addTextConfig(sectionDiv, type).focus();
        addTimeDateConfig(sectionDiv, type);
    }

    cardDiv.appendChild(sectionDiv);
    configDiv.appendChild(cardDiv);
    configDiv.appendChild(document.getElementById('selectorDiv'));
    document.getElementById('inputType').value = "select a input type";

};



// Continued from previous JavaScript...

const addOptionConfig = (parentDiv, type) => {
    const numOptionsInput = document.createElement('input');
    numOptionsInput.type = 'number';
    numOptionsInput.placeholder = 'Number of Options';
    numOptionsInput.className = 'form-control mb-4';
    // numOptionsInput.name = `${type}[${uniqueId}][numOptions]`;
    numOptionsInput.dataset.type = 'Multiple Choice'; // Add type information
    numOptionsInput.required = true;
    numOptionsInput.oninput = (e) => {
        // Check and remove existing optionDiv if it exists
        const existingOptionDiv = parentDiv.querySelector('.optionDiv');
        if (existingOptionDiv) {
            parentDiv.removeChild(existingOptionDiv);
        }
        // Add new option inputs based on number
        addOptionInputs(e.target.value, parentDiv, uniqueId, type);
    };
    parentDiv.appendChild(numOptionsInput);
    setTimeout(() => {
        placeholderInput.focus();
    }, 300);
};





const addOptionInputs = (count, parentDiv, parentId, type) => {
    let optionDiv = document.createElement('div');
    optionDiv.className = 'optionDiv';

    for (let i = 1; i <= count; i++) {
        const input = document.createElement('input');
        input.type = 'text';
        input.placeholder = `Option ${i}`;
        input.className = 'form-control mb-2';
        input.name = `${type}_${uniqueId}[options][${i - 1}]`;
        input.required = true;
        optionDiv.appendChild(input);
    }
    parentDiv.appendChild(optionDiv);

};




const addTextConfig = (parentDiv, type) => {
    const pretypes = ['Short Answer', 'Long Answer', 'Time', 'Date'];
    const placeholderInput = document.createElement('input');
    placeholderInput.type = 'text';
    placeholderInput.placeholder = 'What is the Question?';
    placeholderInput.className = 'form-control mb-4';
    if (pretypes.includes(type)) {
        placeholderInput.name = `${type}_${uniqueId}[${type}]`;
    }else {
        placeholderInput.name = `${type}_${uniqueId}[${type}]`;
    }
    placeholderInput.dataset.type = 'Short Answer'; // Add type information
    placeholderInput.required = true;
    parentDiv.appendChild(placeholderInput);
    setTimeout(() => {
        placeholderInput.focus();
    }, 300);

    return placeholderInput;
};




const addTimeDateConfig = (parentDiv, type) => {
    const infoText = document.createElement('p');
    infoText.innerText = 'No extra seasoning needed for Time and Date inputs!';
    parentDiv.appendChild(infoText);
    infoText.dataset.type = 'Time/Date'; // Add type information
};



const captureInfo = () => {
    const sections = document.querySelectorAll('[id^="section_"]');
    let compiledData = [];

    sections.forEach(section => {
        const header = section.querySelector('h5').innerText.replace(' Configuration', '');
        const inputElements = Array.from(section.querySelectorAll('input'));

        let configData = {};
        configData.type = header;
        configData.label = inputElements[0].value;

        // Include the type information in the data object
        configData.inputType = inputElements[0].dataset.type;

        if (['Multiple Choice', 'Checkbox', 'Dropdown'].includes(header)) {
            configData.options = inputElements.slice(1).map(el => el.value);
        } else if (['Short Answer', 'Long Answer'].includes(header)) {
            configData.placeholder = inputElements[1].value;
        }

        compiledData.push(configData);
    });

    console.log('Compiled Data:', compiledData);
};



document.addEventListener('DOMContentLoaded', (event) => {
    const el = document.getElementById('configDiv');
    const sortable = Sortable.create(el, {
        handle: '.card-append', // Class name for the handle
        animation: 150
    });
});
