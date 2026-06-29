const BuyBtnSearch = document.getElementById('BuyBtnSearch'); // buy button on search box
const RentBtnSearch = document.getElementById('RentBtnSearch'); // rent button on search box
const BuyBtnFilter = document.getElementById('BuyBtnFilter'); // buy tab in filter modal
const RentBtnFilter = document.getElementById('RentBtnFilter'); // rent tab in filter modal
const BuyContent = document.getElementById('BuyContent'); // buy content in filter modal
const RentContent = document.getElementById('RentContent'); // rent content in filter modal

const SellBtn = document.getElementById('SellBtn'); // Sell button
const RentBtn = document.getElementById('RentBtn'); // Rent button
const AllBtn = document.getElementById('AllBtn'); // All button
const propertyItems = document.querySelectorAll('.property-item'); // Property cards

// document.addEventListener('DOMContentLoaded', function() {

// }

// Ensure AllBtn is active when the page is fully loaded
document.addEventListener('DOMContentLoaded', function () {
    // Mark AllBtn as active

    if(AllBtn && SellBtn && RentBtn && BuyBtnSearch && BuyBtnFilter && BuyContent)
    {
        AllBtn.classList.add('active');
        SellBtn.classList.remove('active');
        RentBtn.classList.remove('active');

        BuyBtnSearch.classList.add('active');
        BuyBtnFilter.classList.add('active');
        BuyContent.classList.add('active');
        BuyContent.classList.add('show');
    }

    // Show all property cards by default
    propertyItems.forEach(item => {
        let formTag = item.parentElement; // Form tag
        let parentDiv = formTag.parentElement; // Parent div of the form
        parentDiv.style.display = 'block'; // Ensure all properties are displayed
    });
});

// Buy/Rent tab switching
if(BuyBtnSearch && RentBtnSearch && AllBtn && SellBtn && RentBtn)
{
    BuyBtnSearch.addEventListener('click', () => {
        BuyBtnSearch.classList.add('active');
        RentBtnSearch.classList.remove('active');
        BuyContent.classList.add('active', 'show');
        RentContent.classList.remove('active', 'show');
        BuyBtnFilter.classList.add('active');
        RentBtnFilter.classList.remove('active');
    });

    RentBtnSearch.addEventListener('click', () => {
        RentBtnSearch.classList.add('active');
        BuyBtnSearch.classList.remove('active');
        RentContent.classList.add('active', 'show');
        BuyContent.classList.remove('active', 'show');
        BuyBtnFilter.classList.remove('active');
        RentBtnFilter.classList.add('active');
    });

    // Show all properties
    AllBtn.addEventListener('click', () => {
        AllBtn.classList.add('active');
        SellBtn.classList.remove('active');
        RentBtn.classList.remove('active');

        propertyItems.forEach(item => {
            let formTag = item.parentElement; // Form tag
            let parentDiv = formTag.parentElement; // Parent div of the form
            parentDiv.style.display = 'block'; // Show all
        });
    });

    // Show only Sale properties
    SellBtn.addEventListener('click', () => {
        SellBtn.classList.add('active');
        RentBtn.classList.remove('active');
        AllBtn.classList.remove('active');

        propertyItems.forEach(item => {
            let formTag = item.parentElement; // Form tag
            let parentDiv = formTag.parentElement; // Parent div of the form
            if (item.classList.contains('Sale')) {
                parentDiv.style.display = 'block'; // Show Sale items
            } else {
                parentDiv.style.display = 'none'; // Hide others
            }
        });
    });

    // Show only Rent properties
    RentBtn.addEventListener('click', () => {
        RentBtn.classList.add('active');
        SellBtn.classList.remove('active');
        AllBtn.classList.remove('active');

        propertyItems.forEach(item => {
            let formTag = item.parentElement; // Form tag
            let parentDiv = formTag.parentElement; // Parent div of the form
            if (item.classList.contains('Rent')) {
                parentDiv.style.display = 'block'; // Show Rent items
            } else {
                parentDiv.style.display = 'none'; // Hide others
            }
        });
    });
}
