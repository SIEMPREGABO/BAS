    <!-- FOOTER -->
    <footer class="footer">
        <div class="container footer-grid">
            <div>
                <h5>Enlaces</h5>
                <a href="index.php">Inicio</a>
                <a href="nosotros.php">Acerca de nosotros</a>
                <a href="index.php#servicios">Servicios</a>
                <a href="index.php#contacto">Contacto</a>
            </div>

            <div>
                <h5>Contacto</h5>
                <p>Tel: 56 2576 4706</p>
                <p>Email: reservaciones@beautyandsoul.com</p>
            </div>

            <div>
                <h5>Síguenos</h5>
                <a href="https://www.facebook.com/share/14kCMCcHzf/?mibextid=wwXIfr" target="_blank">Facebook</a>
                <a href="https://www.tiktok.com/@beautyandsoul.cabina?_t=ZM-8vZVtla2F54&_r=1" target="_blank">TikTok</a>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container footer-bottom-content">
                <p>© 2025 Beauty & Soul - Todos los derechos reservados / Desarrollado por <span class="footer-brand">XIPELY</span></p>
            </div>
        </div>
    </footer>

    <!-- BOTONES FLOTANTES -->
    <!-- <div class="social-float">
        <a href="https://www.facebook.com/share/14kCMCcHzf/?mibextid=wwXIfr" target="_blank" aria-label="Facebook">
            <i class="fa-brands fa-facebook-f"></i>
        </a>
        <a href="https://www.tiktok.com/@beautyandsoul.cabina?_t=ZM-8vZVtla2F54&_r=1" target="_blank" aria-label="TikTok">
            <i class="fa-brands fa-tiktok"></i>
        </a>
        <a href="https://wa.me/525625764706?text=Hola%2C%20he%20visto%20su%20p%C3%A1gina%20y%20estoy%20muy%20interesad%40%20en%20reservar%20un%20servicio.%20%E2%9D%A4%EF%B8%8F" target="_blank" aria-label="WhatsApp">
            <i class="fa-brands fa-whatsapp"></i>
        </a>
    </div> -->

    <!-- MODAL RESERVA -->
    <div class="modal" id="reserva-modal" aria-hidden="true">
        <div class="modal-backdrop" data-close="modal"></div>
        <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="reserva-title">
            <button class="modal-close" type="button" aria-label="Cerrar" data-close="modal"><i class="fa-solid fa-x"></i></button>
            <h3 class="modal-title" id="reserva-title">Reserva tu Servicio</h3>
            <form class="reserva-form">
                <div class="form-section">
                    <p class="form-section-title">Contacto del cliente</p>
                    <div class="form-grid">
                        <input type="text" name="nombre" placeholder="Nombre Completo" required />
                        <input type="tel" name="telefono" placeholder="Teléfono" required />
                        <input class="full" type="email" name="correo" placeholder="Correo Electrónico" required />
                    </div>
                </div>
                <div class="form-section">
                    <p class="form-section-title">Detalles del servicio</p>
                    <div class="form-grid">
                        <select name="servicio" id="servicio-select" required>
                            <option value="">Selecciona un servicio</option>
                            <option value="Brisa de serenidad" data-is-package="1" data-duration="120 min">Brisa de serenidad (Paquete)</option>
                            <option value="Esencia radiante" data-is-package="1" data-duration="105 min">Esencia radiante (Paquete)</option>
                            <option value="Detox &amp; Equilibrio" data-is-package="1" data-duration="120 min">Detox &amp; Equilibrio (Paquete)</option>
                            <option value="Ritual cuerpo &amp; alma" data-is-package="1" data-duration="135 min">Ritual cuerpo &amp; alma (Paquete)</option>
                            <option value="Día glow cumpleañera/o" data-is-package="1" data-duration="105 min">Día glow cumpleañera/o (Paquete)</option>
                            <option value="Calma profunda" data-is-package="1" data-duration="120 min">Calma profunda (Paquete)</option>
                            <option value="Día zen express" data-is-package="1" data-duration="90 min">Día zen express (Paquete)</option>
                            <option value="Mini ritual de amor" data-is-package="1" data-duration="100 min">Mini ritual de amor (Paquete)</option>
                            <option value="Masaje Relajante">Masaje Relajante</option>
                            <option value="Masaje Descontracturante">Masaje Descontracturante</option>
                            <option value="Masaje Sueco">Masaje Sueco</option>
                            <option value="Masaje Terapéutico">Masaje Terapéutico</option>
                            <option value="Masaje Deportivo">Masaje Deportivo</option>
                            <option value="Masaje Con Ventosas">Masaje Con Ventosas</option>
                            <option value="Masaje Drenaje Linfático">Masaje Drenaje Linfático</option>
                            <option>Antiacné (Facial)</option>
                            <option>Antiedad (Facial)</option>
                            <option>Drenaje Facial (Facial)</option>
                            <option>Fototerapia LED (Facial)</option>
                            <option>Hidratante (Facial)</option>
                            <option>Limpieza Facial Profunda (Facial)</option>
                            <option>Microdermoabrasión (Facial)</option>
                            <option>Reafirmante (Facial)</option>
                            <option>Regenerante (Facial)</option>
                        </select>
                        <select name="duracion" id="duracion-select" required>
                            <option value="">Selecciona duración</option>
                            <option>30 min</option>
                            <option>45 min</option>
                            <option>50 min</option>
                            <option>60 min</option>
                            <option>80 min</option>
                            <option>90 min</option>
                            <option>100 min</option>
                            <option>105 min</option>
                            <option>120 min</option>
                            <option>135 min</option>
                        </select>
                        <input type="date" name="fecha" required />
                        <select name="hora" required>
                            <option value="">Selecciona una hora</option>
                            <option>09:00</option>
                            <option>10:30</option>
                            <option>12:00</option>
                            <option>14:00</option>
                            <option>16:00</option>
                            <option>18:00</option>
                        </select>
                        <textarea class="full" name="notas" rows="3" placeholder="Notas adicionales (opcional)"></textarea>
                    </div>
                </div>
                <button class="btn-primary modal-submit" type="submit">Confirmar Reservación</button>
            </form>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/js/glightbox.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/social-widget.js"></script>

</body>

</html>
