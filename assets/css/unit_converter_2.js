
    function generateTooltipContent(value, unit) {
      value = parseFloat(value);
      let kanal, marla, sqft, sqyard;

      if (unit === "Sqft") {
        kanal = value / 5445;
        marla = value / 225;
        sqyard = value * 0.11111;
        return `Kanal: ${kanal.toFixed(2)}<br>Marla: ${marla.toFixed(2)}<br>sq.yd: ${sqyard.toFixed(2)}`;
      }
      if (unit === "Kanal") {
        sqft = value * 5445;
        marla = value * 20;
        sqyard = value * 605;
        return `Sqft: ${sqft.toFixed(2)}<br>Marla: ${marla.toFixed(2)}<br>sq.yd: ${sqyard.toFixed(2)}`;
      }
      if (unit === "Marla") {
        kanal = value * 0.05;
        sqft = value * 272.25;
        sqyard = value * 30.25;
        return `Kanal: ${kanal.toFixed(2)}<br>Sqft: ${sqft.toFixed(2)}<br>sq.yd: ${sqyard.toFixed(2)}`;
      }
      if (unit === "sq.yd") {
        kanal = value * 0.00165;
        marla = value * 0.04;
        sqft = value * 9;
        return `Kanal: ${kanal.toFixed(2)}<br>Marla: ${marla.toFixed(2)}<br>Sqft: ${sqft.toFixed(2)}`;
      }
      return "Invalid Unit";
    }

    const buttons = document.querySelectorAll('.tooltipBtn');
    buttons.forEach(button => {
      const value = button.getAttribute("value");
      const unit = button.getAttribute("data-unit");

      tippy(button, {
        content: generateTooltipContent(value, unit),
        allowHTML: true,
        interactive: true,
        placement: 'bottom',
        theme: 'own',
        followCursor: 'horizontal',
        duration: [800, 500],
      });
    });
