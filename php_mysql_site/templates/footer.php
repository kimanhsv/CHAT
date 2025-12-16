<?php
// footer.php - closes the Tailwind admin layout from header.php
?>
    </div>
  </main>
  <!-- END: Main Content -->
</div>
<script data-purpose="toggle-switch-handler">
    // Enhanced toggle handler: initialize visuals and sync hidden inputs
    document.querySelectorAll('[role="switch"]').forEach(button => {
      const handle = button.querySelector('span[aria-hidden="true"]');
      const hiddenId = button.dataset.input;
      const hidden = hiddenId ? document.getElementById(hiddenId) : null;

      function updateVisual(){
        const isChecked = button.getAttribute('aria-checked') === 'true';
        button.classList.toggle('bg-green-500', isChecked);
        button.classList.toggle('bg-gray-200', !isChecked);
        if(handle){
          handle.classList.toggle('translate-x-5', isChecked);
          handle.classList.toggle('translate-x-0', !isChecked);
        }
        if(hidden){ hidden.value = isChecked ? '1' : '0'; }
      }

      // initialize visual state
      updateVisual();

      button.addEventListener('click', () => {
        const isChecked = button.getAttribute('aria-checked') === 'true';
        button.setAttribute('aria-checked', (!isChecked).toString());
        updateVisual();
      });
    });
  </script>
</body>
</html>