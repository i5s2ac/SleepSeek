from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException, NoSuchElementException
from selenium.webdriver.support.ui import Select
import time


def profile(driver):

    number_test = "10597845"
    birthday_test = "05242001"
    gender_test = "femenino"
    country_test = "Estados Unidos"
    direction_test = "123 Main Street Anytown, USA 12345"
    dpi_test = "1418397540101"

    try:
        # Establece un tiempo de espera máximo de 10 segundos
        wait = WebDriverWait(driver, 10)

        # Espera hasta que el elemento sea visible y pueda hacer clic en él
        number = wait.until(EC.visibility_of_element_located((By.ID, 'number'))).send_keys(number_test) #input para numero del usuario
        time.sleep(2)
        birthday = wait.until(EC.visibility_of_element_located((By.ID, 'birthday'))).send_keys(birthday_test) #input para fecha de nacimiento
        time.sleep(2) 
        gender = wait.until(EC.visibility_of_element_located((By.ID, 'gender')))#input para genero del usuario
        select = Select(gender)
        select.select_by_value(gender_test)
        time.sleep(2) 
        country = wait.until(EC.visibility_of_element_located((By.ID, 'country')))#input para pais del usuario
        select = Select(country)
        select.select_by_value(country_test)
        time.sleep(2) 
        direction = wait.until(EC.visibility_of_element_located((By.ID,'direction'))).send_keys(direction_test) #input para direccion 
        time.sleep(2) 
        dpi = wait.until(EC.visibility_of_element_located((By.ID,'DPI'))).send_keys(dpi_test) #input para direccion 
        time.sleep(2) 
        boton = wait.until(EC.visibility_of_element_located((By.CLASS_NAME, 'bg-gray-800'))).click() #boton 

    except TimeoutException:
        print("Tiempo de espera agotado. Alguno de los elementos no apareció a tiempo.")

    except NoSuchElementException:
        print("Elemento no encontrado. Puede que alguno de los elementos no exista en la página.")

    finally:
        # Cierra el navegador en un bloque finally para asegurarte de que se cierre incluso si ocurre una excepción.
        if 'driver' in locals() or 'driver' in globals():
            driver.quit()