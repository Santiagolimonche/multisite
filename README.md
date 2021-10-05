# multisite
Example plugin multisite.
Para borrar varias clave-valor en todas las tablas options en un WordPress Multisite mediante un comando WP-CLI:
<pre><code>wp site list --field=url | xargs -n1 -I % wp --url=% option delete fs_active_plugins fs_accounts fs_debug_mode fs_wsalp<code></pre>

Para devolver el string con la información del plugin, se emplea el método SL_Multisite_Plugin::sl_multisite_wp_footer(); en la parte del código que se necesite.
Para evitar conflictos si se deja desactivado, se recomienda emplear:
<pre><code>if (class_exists('SL_Multisite_Plugin')) {
   echo SL_Multisite_Plugin::sl_multisite_wp_footer();
}<code></pre>
