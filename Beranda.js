// Menentukan bulan saat ini (November 2024)
const months = [
    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
];

const daysInMonth = [
    31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31
];

const events = {}; // Untuk menyimpan acara berdasarkan tanggal

// Fungsi untuk generate kalender bulan tertentu
function generateMonthCalendar(monthIndex, year) {
    const calendarElement = document.getElementById("novemberCalendar");
    calendarElement.innerHTML = ''; // Clear calendar before rendering

    const monthDiv = document.createElement("div");
    monthDiv.classList.add("month");

    // Header Bulan
    const monthHeader = document.createElement("div");
    monthHeader.classList.add("month-header");
    monthHeader.textContent = `${months[monthIndex]} ${year}`;
    monthDiv.appendChild(monthHeader);

    // Body bulan (grid hari)
    const monthBody = document.createElement("div");
    monthBody.classList.add("month-body");

    // Menampilkan nama hari (Senin, Selasa, ... Sabtu)
    const weekDays = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];
    weekDays.forEach(day => {
        const dayElement = document.createElement("div");
        dayElement.textContent = day;
        monthBody.appendChild(dayElement);
    });

    // Menentukan hari pertama bulan ini (untuk penempatan tanggal)
    const firstDay = new Date(year, monthIndex, 1).getDay();

    // Menambahkan spasi kosong untuk hari pertama
    for (let i = 0; i < firstDay; i++) {
        const blankDiv = document.createElement("div");
        monthBody.appendChild(blankDiv);
    }

    // Menambahkan hari-hari dalam bulan
    for (let day = 1; day <= daysInMonth[monthIndex]; day++) {
        const dayDiv = document.createElement("div");
        dayDiv.classList.add("day");
        dayDiv.textContent = day;
        dayDiv.dataset.date = `${year}-${String(monthIndex + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

        // Menambahkan acara jika ada
        if (events[dayDiv.dataset.date]) {
            dayDiv.classList.add("has-event");
        }

        // Menambahkan event listener untuk menandai tanggal dan menambahkan keterangan
        dayDiv.addEventListener("click", function() {
            openEventModal(dayDiv.dataset.date);
        });

        monthBody.appendChild(dayDiv);
    }

    monthDiv.appendChild(monthBody);
    calendarElement.appendChild(monthDiv);
}

// Fungsi untuk generate kalender penuh (12 bulan)
function generateFullCalendar(year) {
    const fullCalendarElement = document.getElementById("fullCalendar");
    fullCalendarElement.innerHTML = ''; // Clear full calendar before rendering

    for (let monthIndex = 0; monthIndex < 12; monthIndex++) {
        const monthDiv = document.createElement("div");
        monthDiv.classList.add("month");

        // Header bulan
        const monthHeader = document.createElement("div");
        monthHeader.classList.add("month-header");
        monthHeader.textContent = `${months[monthIndex]} ${year}`;
        monthDiv.appendChild(monthHeader);

        // Body bulan
        const monthBody = document.createElement("div");
        monthBody.classList.add("month-body");

        // Menampilkan nama hari (Senin, Selasa, ... Sabtu)
        const weekDays = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];
        weekDays.forEach(day => {
            const dayElement = document.createElement("div");
            dayElement.textContent = day;
            monthBody.appendChild(dayElement);
        });

        // Menentukan hari pertama bulan ini
        const firstDay = new Date(year, monthIndex, 1).getDay();

        // Menambahkan spasi kosong untuk hari pertama
        for (let i = 0; i < firstDay; i++) {
            const blankDiv = document.createElement("div");
            monthBody.appendChild(blankDiv);
        }

        // Menambahkan hari-hari dalam bulan
        for (let day = 1; day <= daysInMonth[monthIndex]; day++) {
            const dayDiv = document.createElement("div");
            dayDiv.classList.add("day");
            dayDiv.textContent = day;
            dayDiv.dataset.date = `${year}-${String(monthIndex + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

            // Menambahkan acara jika ada
            if (events[dayDiv.dataset.date]) {
                dayDiv.classList.add("has-event");
            }

            // Menambahkan event listener untuk menandai tanggal dan menambahkan keterangan
            dayDiv.addEventListener("click", function() {
                openEventModal(dayDiv.dataset.date);
            });

            monthBody.appendChild(dayDiv);
        }

        monthDiv.appendChild(monthBody);
        fullCalendarElement.appendChild(monthDiv);
    }
}

// Modal untuk menambahkan acara (termasuk jam dan tempat)
function openEventModal(date) {
    const description = prompt("Masukkan keterangan untuk tanggal " + date);
    if (description) {
        // Meminta waktu mulai acara dengan format 12 jam (AM/PM) atau 24 jam
        const startTime = prompt("Masukkan jam mulai acara (misal: 14:00 atau 2:00 PM)");

        // Meminta waktu selesai acara dengan format yang sama
        const endTime = prompt("Masukkan jam selesai acara (misal: 16:00 atau 4:00 PM)");

        // Meminta tempat acara
        const location = prompt("Masukkan tempat acara");

        // Simpan acara dengan tanggal, keterangan, jam mulai, jam selesai, dan tempat
        events[date] = {
            description: description,
            startTime: startTime,
            endTime: endTime,
            location: location
        };

        // Update daftar acara
        updateEventList();

        // Update kalender bulan November
        generateMonthCalendar(10, 2024);  // Pastikan ini merender ulang kalender bulan tertentu

        // Update kalender penuh
        generateFullCalendar(2024);  // Pastikan kalender penuh terupdate
    }
}

// Menampilkan daftar acara di panel
function updateEventList() {
    const eventList = document.getElementById("eventList");
    eventList.innerHTML = ''; // Clear daftar acara sebelum menampilkan

    // Iterasi untuk menampilkan acara dengan tanggal, keterangan, jam mulai, jam selesai, dan tempat
    for (const date in events) {
        const eventItem = document.createElement("li");
        eventItem.textContent = `${date}: ${events[date].description} | Jam Mulai: ${events[date].startTime} | Jam Selesai: ${events[date].endTime} | Tempat: ${events[date].location}`;
        eventList.appendChild(eventItem);
    }
}

// Menampilkan kalender bulan November 2024 saat halaman dimuat
window.onload = function() {
    generateMonthCalendar(10, 2024); // November adalah bulan ke-10 (indeks dimulai dari 0)
};

// Fungsi untuk membuka modal kalender tahun penuh
document.getElementById("novemberCalendar").addEventListener("click", function() {
    const modal = document.getElementById("fullCalendarModal");
    modal.style.display = "block";
    generateFullCalendar(2024); // Generate kalender 12 bulan
});

// Event listener untuk menutup modal
document.querySelector(".close").addEventListener("click", function() {
    const modal = document.getElementById("fullCalendarModal");
    modal.style.display = "none";
});
