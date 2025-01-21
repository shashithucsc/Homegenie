
function toggleDropdown() {
    const dropdown = document.getElementById("dropdown");
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
}


const notifications = [
    "New customer rated your product",
    "Order #1023 completed",
    "New review received",
    "Product stock updated",
];
const notificationsList = document.getElementById("notifications-list");

setInterval(() => {
    const randomNotification = notifications[Math.floor(Math.random() * notifications.length)];
    const listItem = document.createElement("li");
    listItem.textContent = randomNotification;
    notificationsList.appendChild(listItem);

    if (notificationsList.childElementCount > 5) {
        notificationsList.removeChild(notificationsList.firstChild);
    }
}, 5000);


