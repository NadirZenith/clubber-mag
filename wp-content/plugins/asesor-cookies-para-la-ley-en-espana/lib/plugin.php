<?php

/* ======================================================================================
   @author     Carlos Doral Pérez (http://webartesanal.com)
   @version    0.15
   @copyright  Copyright &copy; 2013-2014 Carlos Doral Pérez, All Rights Reserved
               License: GPLv2 or later
   ====================================================================================== */

/**
 *
 */
class cdp_cookies
{
	/**
	 *
	 */
	static function ejecutar()
	{
		//
		// Plugin no puede ser ejecutado directamente
		//
		if( !( function_exists( 'add_action' ) && defined( 'ABSPATH' ) ) )
			throw new cdp_cookies_error( 'Este plugin no puede ser llamado directamente' );
		
		//
		// Registro eventos front y comunes
		//
		add_action( 'wp_ajax_traer_aviso', array( __CLASS__, 'ajax_traer_aviso' ) );
		add_action( 'wp_ajax_nopriv_traer_aviso', array( __CLASS__, 'ajax_traer_aviso' ) );
		add_action( 'wp_ajax_traer_aviso_get', array( __CLASS__, 'ajax_traer_aviso_get' ) );
		add_action( 'wp_ajax_nopriv_traer_aviso_get', array( __CLASS__, 'ajax_traer_aviso_get' ) );
		
		//
		// Ejecutando Admin
		//
		if( is_admin() )
		{
			add_action( 'admin_menu', array( __CLASS__, 'crear_menu_admin' ) );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'cargar_archivos_admin' ) );
			add_action( 'wp_ajax_guardar_config', array( __CLASS__, 'ajax_guardar_config' ) );			
			add_action( 'wp_ajax_crear_paginas', array( __CLASS__, 'ajax_crear_paginas' ) );			
			return;
		}
		
		//
		// Ejecutando front
		//
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'cargar_archivos_front' ) );
	}
	
	/**
	 *
	 */
	static function cargar_archivos_front()
	{
		wp_enqueue_style( 'front-estilos', CDP_COOKIES_URL_HTML . 'front/estilos.css', false );
		wp_enqueue_script( 'front-cookie', CDP_COOKIES_URL_HTML . 'front/_jquery.kookie.js', array( 'jquery' ) );
		wp_enqueue_script( 'front-lib', CDP_COOKIES_URL_HTML . 'front/lib.js', array( 'jquery' ) );
		wp_enqueue_script( 'front-principal', CDP_COOKIES_URL_HTML . 'front/principal.js', array( 'jquery' ) );
		wp_localize_script
		( 
			'front-principal', 
			'cdp_cookies_info',
			array
			(
				'url_plugin' => CDP_COOKIES_URL_RAIZ . 'plugin.php',
				'url_admin_ajax' => admin_url() . 'admin-ajax.php',
				'url_traer_aviso_php' => CDP_COOKIES_TRAER_AVISO_PHP_URL,
				'comportamiento' => self::parametro( 'comportamiento' )
			) 
		);
	}

	/**
	 *
	 */
	static function ajax_traer_aviso()
	{
		//
		// Posicionamiento en ventana o página
		//
		$class = '';
		if( self::parametro( 'layout' ) == 'ventana' )
			$class .= ' cdp-cookies-layout-ventana';
		else
			$class .= ' cdp-cookies-layout-pagina';
		
		//
		// Posición: superior, inferior
		//
		$class .= ' cdp-cookies-pos-' . self::parametro( 'posicion' );

		//
		// Alineación de los textos
		//
		if( self::parametro( 'alineacion' ) == 'izq' )
			$class .= ' cdp-cookies-textos-izq';

		//
		// Tema de color
		//
		$class .= ' cdp-cookies-tema-' . self::parametro( 'tema' );

		//
		// Preparo el texto
		//
		$tam_fuente = self::parametro( 'tam_fuente' );
		$tam_fuente_titulo = str_replace( 'px', '', $tam_fuente ) + 3;
		$estilo_texto = 'style="font-size:{tam_fuente} !important;line-height:{tam_fuente} !important"';
		$estilo_titulo = 'style="font-size:{tam_fuente_titulo}px !important;line-height:{tam_fuente_titulo}px !important"';
		$estilo_enlace = 'style="font-size:{tam_fuente} !important;line-height:{tam_fuente} !important"';
		$texto_aviso = html_entity_decode( self::parametro( 'texto_aviso' ) );
		
		//
		$html = file_get_contents( CDP_COOKIES_DIR_HTML . 'front/aviso.html' );
		$html = str_replace( '{texto_aviso}', $texto_aviso, $html );
		$html = str_replace( '{estilo_texto}', $estilo_texto, $html );
		$html = str_replace( '{estilo_titulo}', $estilo_titulo, $html );
		$html = str_replace( '{estilo_enlace}', $estilo_enlace, $html );
		$html = str_replace( '{class}', $class, $html );
		$html = str_replace( '{enlace_politica}', self::parametro( 'enlace_politica' ), $html );
		$html = str_replace( '{tam_fuente}', $tam_fuente, $html );
		$html = str_replace( '{tam_fuente_titulo}', $tam_fuente_titulo, $html );
		
		//
		$boton = '';
		if( self::parametro( 'comportamiento' ) == 'cerrar' )
			$boton = '<a href="#" class="cdp-cookies-boton-cerrar">CERRAR</a>';
		if( self::parametro( 'comportamiento' ) == 'aceptar' )
			$boton = '<a href="#" class="cdp-cookies-boton-cerrar">ACEPTAR</a>';
		$html = str_replace( '{boton_cerrar}', $boton, $html );
		
		//
		echo 
			json_encode
			( 
				array
				( 
					'html' => $html, 
					'posicion' => self::parametro( 'posicion' ),
					'layout' => self::parametro( 'layout' )
				)
			);
		exit;
	}
	
	/**
	 *
	 */
	static function ajax_crear_paginas()
	{
		try
		{
			//
			self::comprobar_usuario_admin();
				
			//
			if( !wp_verify_nonce( cdp_cookies_input::post( 'nonce_crear_paginas' ), 'crear_paginas' ) )
				throw new cdp_cookies_error_nonce();

			// Pág. mas info
			$pag_info = new cdp_cookies_pagina();
			$pag_info->titulo = 'Más información sobre las cookies';
			$pag_info->html = file_get_contents( CDP_COOKIES_DIR_HTML . 'front/mas-informacion.html' );
			if( !$pag_info->crear() )
				throw new cdp_cookies_error( $pag_info->mensaje );
			
			// importante! Guardo la url de la página info que será usada por la política
			self::parametro( 'enlace_mas_informacion', $pag_info->url );
			
			// Pág. política
			$pag_pol = new cdp_cookies_pagina();
			$pag_pol->titulo = 'Política de cookies';
			$pag_pol->html =
				str_replace
				(
					'{enlace_mas_informacion}',
					self::parametro( 'enlace_mas_informacion' ),
					file_get_contents( CDP_COOKIES_DIR_HTML . 'front/politica.html' )
				);
			if( !$pag_pol->crear() )
				throw new cdp_cookies_error( $pag_pol->mensaje );

			// Todo ok!
			$resul = array( 'ok' => true, 'url_info' => $pag_info->url, 'url_politica' => $pag_pol->url );
			if( $pag_pol->ya_existia || $pag_info->ya_existia )
				$resul['txt'] = 'Alguna de las página ya existía y no ha sido necesario crearla';
			else
				$resul['txt'] = 'Páginas creadas correctamente';
			echo json_encode( $resul );
		}
		catch( Exception $e )
		{
			cdp_cookies_log::pon( $e );
			echo json_encode( array( 'ok' => false, 'txt' => $e->getMessage() ) );
		}
		exit;
	}

	/**
	 *
	 */
	static function ajax_guardar_config()
	{
		try
		{
			//
			self::comprobar_usuario_admin();
				
			//
			if( !wp_verify_nonce( cdp_cookies_input::post( 'nonce_guardar' ), 'guardar' ) )
				throw new cdp_cookies_error_nonce();

			//
			cdp_cookies_input::validar_array( 'layout', array( 'ventana', 'pagina' ) );
			cdp_cookies_input::validar_array( 'comportamiento', array( 'navegar', 'cerrar', 'aceptar' ) );
			cdp_cookies_input::validar_array( 'posicion', array( 'superior', 'inferior' ) );
			cdp_cookies_input::validar_array( 'alineacion', array( 'izq', 'cen' ) );
			cdp_cookies_input::validar_array( 'tema', array( 'gris', 'blanco', 'azul', 'verde', 'rojo' ) );
			cdp_cookies_input::validar_url( 'enlace_politica' );
			cdp_cookies_input::validar_url( 'enlace_mas_informacion' );
			if( !cdp_cookies_input::post( 'texto_aviso' ) )
				throw new cdp_cookies_error( "El texto del aviso no puede estar vacío" );
			if( !preg_match( '/^[0-9]+px$/i', cdp_cookies_input::post( 'tam_fuente' ) ) )
				throw new cdp_cookies_error( 
					"<b>Tamaño de fuente del texto</b> debe tener un valor en px, p.e: 12px" 
				);
				
			//
			self::parametro( 'layout', cdp_cookies_input::post( 'layout' ) );
			self::parametro( 'posicion', cdp_cookies_input::post( 'posicion' ) );
			self::parametro( 'comportamiento', cdp_cookies_input::post( 'comportamiento' ) );
			self::parametro( 'alineacion', cdp_cookies_input::post( 'alineacion' ) );
			self::parametro( 'tema', cdp_cookies_input::post( 'tema' ) );
			self::parametro( 'enlace_politica', cdp_cookies_input::post( 'enlace_politica' ) );
			self::parametro( 'enlace_mas_informacion', cdp_cookies_input::post( 'enlace_mas_informacion' ) );
			self::parametro( 'texto_aviso', cdp_cookies_input::post( 'texto_aviso' ) );
			self::parametro( 'tam_fuente', cdp_cookies_input::post( 'tam_fuente' ) );
				
			//
			echo json_encode( array( 'ok' => true, 'txt' => 'Configuración guardada correctamente' ) );
		}
		catch( Exception $e )
		{
			cdp_cookies_log::pon( $e );
			echo json_encode( array( 'ok' => false, 'txt' => $e->getMessage() ) );
		}
		exit;
	}

	/**
	 *
	 */
	static function parametro( $nombre, $valor = null )
	{
		//
		$vdef =
			array
			(
				'layout' => 'ventana',
				'posicion' => 'superior',
				'comportamiento' => 'navegar',
				'alineacion' => 'izq',
				'tema' => 'gris',
				'enlace_politica' => '#',
				'enlace_mas_informacion' => '#',
				'texto_aviso' => htmlspecialchars( '<h4 {estilo_titulo}>Uso de cookies</h4><p {estilo_texto}>Este sitio web utiliza cookies para que usted tenga la mejor experiencia de usuario. Si continúa navegando está dando su consentimiento para la aceptación de las mencionadas cookies y la aceptación de nuestra <a href="{enlace_politica}" {estilo_enlace}>política de cookies</a>, pinche el enlace para mayor información.<a href="http://wordpress.org/plugins/asesor-cookies-para-la-ley-en-espana/" class="cdp-cookies-boton-creditos" target="_blank">plugin cookies</a></p>' ),
				'tam_fuente' => '12px'
			);
		if( !key_exists( $nombre, $vdef ) )
			throw new cdp_cookies_error( sprintf( "Parámetro desconocido: %s", $nombre ) );
	
		// Devuelvo valor
		if( $valor === null )
		{
			// Hago una excepción si estoy mostrando el aviso en vista previa
			if( cdp_cookies_input::post( 'cdp_cookies_vista_previa' ) )
				if( ( $v = cdp_cookies_input::post( $nombre ) ) )
				{
					// Antes de devolver el valor me aseguro que soy el usuario administrador
					try
					{
						self::comprobar_usuario_admin();
						if( $nombre == 'texto_aviso' )
							return rawurldecode( $v );
						return $v;
					}
					catch( cdp_cookies_error $e )
					{
					}
				}
			if( $nombre == 'texto_aviso' )
				return stripslashes( get_option( 'cdp_cookies_' . $nombre, $vdef[$nombre] ) );
			return get_option( 'cdp_cookies_' . $nombre, $vdef[$nombre] );
		}
	
		// Lo almaceno
		update_option( 'cdp_cookies_' . $nombre, $valor );
	}
	
	/**
	 *
	 */
	static function cargar_archivos_admin()
	{
		wp_enqueue_style( 'admin-estilos', CDP_COOKIES_URL_HTML . 'admin/estilos.css', false );
		wp_register_script( 'admin-principal', CDP_COOKIES_URL_HTML . 'admin/principal.js', array( 'jquery' ) );
		wp_enqueue_script( 'admin-principal' );
		wp_localize_script(
			'admin-principal',
			'cdp_cookies_info',
			array
			(
				'nonce_guardar' => wp_create_nonce( 'guardar' ),
				'nonce_crear_paginas' => wp_create_nonce( 'crear_paginas' ),
				'siteurl' => site_url(),
				'comportamiento' => self::parametro( 'comportamiento' )
			) 
		);
	}
	
	/**
	 *
	 */
	static function comprobar_usuario_admin()
	{
		if( function_exists( 'current_user_can' ) )
			if( function_exists( 'wp_get_current_user' ) )
				if( current_user_can( 'manage_options' ) )
					return;
		throw new cdp_cookies_error( 'No tiene privilegios para acceder a esta página' );
	}
	
	/**
	 *
	 */
	static function crear_menu_admin()
	{
		//
		// Página configuración que cuelgue de Herramientas
		//
		add_submenu_page
		(
			'tools.php',
			'Asesor de cookies',
			'Asesor de cookies',
			'manage_options',
			'cdp_cookies',
			array( __CLASS__, 'pag_configuracion' )
		);
	}	

	/**
	 *
	 */
	static function pag_configuracion()
	{
		require_once CDP_COOKIES_DIR_HTML . 'admin/principal.html';
	}
}

/**
 *
 */

/**
 *
 */
class cdp_cookies_pagina
{
	/**
	 * entrada
	 */
	public $titulo, $html;

	/**
	 * salida
	 */
	public $ya_existia, $url, $ok, $mensaje;
	
	/**
	 * 
	 */
	function crear()
	{
		// Validación del título
		if( !$this->titulo )
		{
			$this->ok = false;
			$this->mensaje = 'Falta el título de la página';
			return false;
		}
		
		// Compruebo si ya existe
		if( $pag = get_page_by_title( $this->titulo ) )
		{
			// Si está en la papelera...
			if( $pag->post_status == 'trash' )
			{
				$this->ok = false;
				$this->mensaje = 'Alguna de las páginas está en la papelera, debe eliminarla primero';
				return false;
			}

			// Todo bien...
			$this->ok = true;
			$this->ya_existia = true;
			$this->url = get_permalink( $pag );
			return true;
		}

		// Validación del html
		if( !$this->html )
		{
			$this->ok = false;
			$this->mensaje = 'Falta el html de la página';
			return false;
		}
		
		// Me dispongo a crear la página insertando el post en BD
		$p = array();
		$p['post_title'] = $this->titulo;
		$p['post_content'] = $this->html;
		$p['post_status'] = 'publish';
		$p['post_type'] = 'page';
		$p['comment_status'] = 'closed';
		$p['ping_status'] = 'closed';
		$p['post_category'] = array( 1 );
		if( !( $id = wp_insert_post( $p ) ) )
		{
			$this->ok = false;
			$this->mensaje = "No es posible crear la página";
			return false;
		}
		
		// Se ha creado la página correctamente
		$this->ok = true;
		$this->ya_existia = false;
		$this->url = get_permalink( get_post( $id ) );
		return true;
	}	
}

?>