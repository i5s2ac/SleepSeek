from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from register_system_testing import register
from profile_system_testing import profile
from new_place_system_testing import new_place
import time


try:
    chrome_options = Options()
    chrome_options.add_argument("webdriver.chrome.driver=C:/Program Files/chromedriver_win32/chromedriver.exe")

    driver = webdriver.Chrome(options=chrome_options)

    #Registarse
    driver.get('http://127.0.0.1:8000/register') 
    register(driver)

    #Completar perfil
    driver.get('http://127.0.0.1:8000/profile') 
    profile(driver)
    time.sleep(5)

    driver.get('http://127.0.0.1:8000/reservas/create')
    new_place(driver)

    driver.get('http://127.0.0.1:8000/reservas')
    time.sleep(5)


except Exception as e:
    print(f"Ocurrió un error: {str(e)}")

finally:
    if 'driver' in locals() or 'driver' in globals():
        driver.quit()