// Update template preview on page load
const selectedOption = document.getElementById('template').selectedOptions[0];
const selectedTemplate = selectedOption.value;
const orgLogo = selectedOption.getAttribute('data-logo');
const orientation = selectedOption.getAttribute('data-orientation');
const templatePreview = document.getElementById('templatePreview');

if (selectedTemplate) {
    const frontImage = selectedOption.getAttribute('data-front-image');
    templatePreview.src = `/CardGenerator/controllers/${frontImage}`;
    templatePreview.style.display = 'block';
    // Update card preview styles based on orientation
    const cardPreview = document.getElementById('templatePreview');
    cardPreview.classList.remove('portrait', 'landscape');
    cardPreview.classList.add(orientation); // Add the orientation class
}

// ...

// Update template preview on change
document.getElementById('template').addEventListener('change', function() {
    const selectedOption = this.selectedOptions[0];
    const selectedTemplate = selectedOption.value;
    const orgLogo = selectedOption.getAttribute('data-logo');
    const orientation = selectedOption.getAttribute('data-orientation');
    const templatePreview = document.getElementById('templatePreview');

    if (selectedTemplate) {
        const frontImage = selectedOption.getAttribute('data-front-image');
        templatePreview.src = `/CardGenerator/controllers/${frontImage}`;
        templatePreview.style.display = 'block';
    } else {
        templatePreview.style.display = 'none';
    }
    // Update card preview styles based on orientation
    const cardPreview = document.getElementById('templatePreview');
    cardPreview.classList.remove('portrait', 'landscape');
    cardPreview.classList.add(orientation); // Add the orientation class
});

// Generate Card Logic
//Hide generateCardBtn on click
document.getElementById('generateCardBtn').addEventListener('click', function () {
    const template = document.getElementById('template').value;
    const frontTemplate = document.getElementById('template').selectedOptions[0].getAttribute('data-front-image');
    const backTemplate = document.getElementById('template').selectedOptions[0].getAttribute('data-back-image');
    const name = document.getElementById('name').value;
    const idNumber = document.getElementById('idNumber').value;
    const department = document.getElementById('department').value;

    const selectedOption = document.getElementById('template').selectedOptions[0];
    const orgName = selectedOption.text;
    const orgLogo = selectedOption.getAttribute('data-logo');
    const orgAddress = selectedOption.getAttribute('data-address');
    const orgPhone = selectedOption.getAttribute('data-phone');
    const orientation = selectedOption.getAttribute('data-orientation');

    const cardFront = document.getElementById('cardFront');
    const cardBack = document.getElementById('cardBack');
    const profileImage = '/CardGenerator/assets/img/profile_images/' + document.body.getAttribute('data-profile-image');

    // Populate the front side
    cardFront.style.backgroundImage = `url('/CardGenerator/controllers/${frontTemplate}')`;
    cardFront.innerHTML = `
        <div class="card ${orientation}">
            <h2>ID CARD</h2>
            <div class="user-info">
                <img src="${profileImage}" alt="User Image" class="user-image">
                <div class="user-data">
                    <h4>${name}</h4>
                    <p>Registration Number: ${idNumber}</p>
                    <p>Department: ${department}</p>
                </div>
            </div>
            <div class="barcode">
                <img src="../../assets/img/logo/barcode.png" alt="">
            </div>
        </div>
    `;

    // Populate the back side
    cardBack.style.backgroundImage = `url('/CardGenerator/controllers/${backTemplate}')`;
    cardBack.innerHTML = `
        <div class="card ${orientation}">
            <div class="note">
                <h2>Note</h2>
                <p>This card is the property of ${orgName}. The card holder has full responsibility of the card.</p>
                <h2>If this card is found, please return it to the respective organization.</h2>
            </div>
            <div class="org-info">
                <img src="/CardGenerator/assets/img/organization_logos/${orgLogo}" alt="${orgName} Logo" class="org-logo">
                <div class="org-data">
                    <h4>${orgName}</h4>
                    <p>Address: ${orgAddress}</p>
                    <p>Phone: ${orgPhone}</p>
                </div>
            </div>
        </div>
    `;

    // Show the card display and the "Request Card" button
    document.getElementById('cardDisplay').style.display = 'block';
    document.getElementById('requestCardBtn').style.display = 'block';
});


document.getElementById('requestCardBtn').addEventListener('click', function () {
    const template = document.getElementById('template').value;
    const idNumber = document.getElementById('idNumber').value;
    const department = document.getElementById('department').value;

    const selectedOption = document.getElementById('template').selectedOptions[0];
    const orgName = selectedOption.text;
    const orgLogo = selectedOption.getAttribute('data-logo');
    const orgAddress = selectedOption.getAttribute('data-address');
    const orgPhone = selectedOption.getAttribute('data-phone');
    const orgId = selectedOption.getAttribute('data-org-id'); // Ensure this attribute is set in the template option

    // Check if orgId is not null or undefined
    if (orgId !== null && orgId !== undefined) {
        fetch('/CardGenerator/controllers/CreateCardController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                template: template,
                idNumber: idNumber,
                department: department,
                org_id: orgId, // Pass the correct orgId value
                orgName: orgName,
                orgLogo: orgLogo,
                orgAddress: orgAddress,
                orgPhone: orgPhone
            })
        })
        .then(response => response.text())
        .then(data => {
            const requestButton = document.getElementById('requestCardBtn');
            const message = document.createElement('p');
            requestButton.style.display = 'none';

            if (data.includes("Card request submitted successfully.")) {
                message.textContent = "Your ID card request has been submitted. You can download your ID card once the organization accepts the request.";
            } else if (data.includes("You have already requested an ID card from this organization.")) {
                message.textContent = "You have already requested an ID card from this organization. Please wait for approval.";
            } else {
                requestButton.style.display = 'block'; // Re-show the button in case of an error
            }

            requestButton.parentNode.insertBefore(message, requestButton);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting your request.');
        });
    } else {
        console.error('Organization ID is not set.');
        alert('An error occurred while submitting your request.');
    }
});

const flipCard = document.querySelector('.flip-card-inner');
document.querySelector('.flip-card').addEventListener('click', function() {
    flipCard.style.transform = flipCard.style.transform === 'rotateY(180deg)' ? '' : 'rotateY(180deg)';
});