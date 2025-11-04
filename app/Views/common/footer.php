<footer id="bot-bar">
    <p>(: this is the bottom navigation bar</p>

</footer>


<script>
document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
  toggle.addEventListener('click', (e) => {
    e.stopPropagation(); // prevent clicks from bubbling up
    const dropdown = toggle.nextElementSibling;

    // Close all other dropdowns first
    document.querySelectorAll('.user-dropdown.open').forEach(menu => {
      if (menu !== dropdown) menu.classList.remove('open');
    });

    dropdown.classList.toggle('open');
  });
});

// Close dropdown if clicking outside
window.addEventListener('click', () => {
  document.querySelectorAll('.user-dropdown.open').forEach(menu => {
    menu.classList.remove('open');
  });
});
</script>

</body>

</html>