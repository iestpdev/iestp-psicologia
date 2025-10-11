const BASE_URL = document.querySelector('meta[name="base-url"]').content;

async function loadInfoReniec() {
  const inputDNI = document.getElementById("dni");
  const nombres = document.getElementById("nombres");
  const apellidos = document.getElementById("apellidos");
  const btnSubmit = document.getElementById("btnSubmit");

  const dni = inputDNI.value.trim();

  if (dni.length === 8) {
    try {
      btnSubmit?.classList.add("disabled");

      const res = await fetch(`${BASE_URL}api/decolecta/dni/${dni}`);
      if (!res.ok) throw new Error("No se pudo obtener los datos del DNI");

      const data = await res.json();

      const persona = typeof data === "string" ? JSON.parse(data) : data;

      if (persona && persona.first_name) {
        nombres.value = persona.first_name;
        apellidos.value = `${persona.first_last_name ?? ""} ${persona.second_last_name ?? ""}`.trim();
      } else {
        nombres.value = "";
        apellidos.value = "";
      }
    } catch (error) {
      console.error("Error al consultar RENIEC:", error);
      nombres.value = "";
      apellidos.value = "";
    } finally {
      btnSubmit?.classList.remove("disabled");
    }
  } else {
    nombres.value = "";
    apellidos.value = "";
    btnSubmit?.classList.remove("disabled");
  }
}

// 🔥 Escucha solo el input del DNI (no todo el documento)
document.addEventListener("DOMContentLoaded", () => {
  const inputDNI = document.getElementById("dni");
  if (inputDNI) {
    inputDNI.addEventListener("input", loadInfoReniec);
  }
});
