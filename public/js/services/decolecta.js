import { showToast } from '../shared/toasts/notyf.js';

const BASE_URL = document.querySelector('meta[name="base-url"]').content;

async function loadInfoReniec() {
  const inputDNI = document.getElementById("dni");
  const nombres = document.getElementById("nombres");
  const apellidos = document.getElementById("apellidos");
  const btnSubmit = document.getElementById("btnSubmit");

  const dni = inputDNI.value.trim();

  if (dni.length !== 8) {
    nombres.value = "";
    apellidos.value = "";
    btnSubmit?.classList.remove("disabled");
    return;
  }

  try {
    btnSubmit?.classList.add("disabled");

    const res = await fetch(`${BASE_URL}api/decolecta/dni/${dni}`);
    const data = await res.json().catch(() => null);

    if (res.status === 200 && data?.first_name) {
      nombres.value = data.first_name;
      apellidos.value = `${data.first_last_name ?? ""} ${data.second_last_name ?? ""}`.trim();
      showToast('success', 'Se encontraron resultados del DNI');
    }
    else if (res.status === 404) {
      nombres.value = "";
      apellidos.value = "";
      showToast('warning', 'DNI no encontrado en RENIEC');
    }
    else if (res.status === 502) {
      nombres.value = "";
      apellidos.value = "";
      showToast('error', 'Error al comunicarse con Decolecta');
    }
    else {
      nombres.value = "";
      apellidos.value = "";
      showToast('error', 'Error inesperado al consultar el DNI');
    }

  } catch (error) {
    console.error("Error al consultar API Decolecta:", error);
    showToast('error', 'Error interno al consultar API Decolecta');
    nombres.value = "";
    apellidos.value = "";
  } finally {
    btnSubmit?.classList.remove("disabled");
  }
}

document.addEventListener("DOMContentLoaded", () => {
  const inputDNI = document.getElementById("dni");
  if (inputDNI) {
    inputDNI.addEventListener("input", loadInfoReniec);
  }
});
