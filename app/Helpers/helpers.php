<?php

    /**
     * Saves File 
     */
    if(!function_exists('save_file')) {
        /* function save_file($file, $folderName, array $allowedExtensions = [], number $maxFileSize = NULL) 
        {        
            $allowedExtensions = count($allowedExtensions) > 0 ? $allowedExtensions : config('custom.allowed_extensions');
            $maxFileSize = isset($maxFileSize) ? $maxFileSize : config('custom.max_upload_size');

            $extension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();

            // Validations
            if(in_array($extension, $allowedExtensions) && $fileSize <= $maxFileSize) {
                $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $file_name = $originalFileName . '_' . time() . '.' . $extension;
                $file_path  = $file->storeAs('public/' . $folderName, $file_name);
                return $file_name;
            } else {
                return;
            }
        } */

        function save_file($file, $folderName) 
        {        
            $extension = $file->getClientOriginalExtension();
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $file_name = $originalFileName . '_' . time() . '.' . $extension;
            $file_path  = $file->storeAs('public/' . $folderName, $file_name);
            return $file_name;
        }
    }

    /**
     * Get post meta
     */
    if(!function_exists('get_meta')) {
        // Getting post meta by meta key and post type determined by the post model class name
        function get_meta($post ,string $meta_key) {
            $postReflection = new ReflectionClass($post);
            $postClassName = $postReflection->getShortName();
            $meta_value =  $post->metas()->where(['post_id' => $post->id, 'post_type' => $postClassName, 'meta_key' => $meta_key])->value('meta_value');
            $unserialized_meta_value = @unserialize($meta_value);
            if ($unserialized_meta_value !== false) {
                return $unserialized_meta_value;
            } else {
                return $meta_value;
            }
        }
    }

    /**
     * Get request meta
     */
    if(!function_exists('get_req_metas')) {
        function get_req_metas($request, string $attribute) {
            // Post metas texts
            $metas = $request->get($attribute) ?? [];            

            // Post meta files
            $meta_files = $request->file($attribute) ?? [];

            return array_merge($metas, $meta_files);
        }
    }

    /**
     * Save meta
     */
    if(!function_exists('save_metas')) {
        function save_metas($post, array $metas, $meta_file_folder = 'posts_meta_files') {
            if(count($metas) > 0) {
                foreach ($metas as $meta_key => $meta_value) {

                    // Save file if file exists
                    if(file_exists($meta_value)) {
                        // Save the file in storage
                        $post_meta_value = save_file($meta_value, $meta_file_folder);
                    } else {
                        $post_meta_value = $meta_value;
                    }

                    $postReflection = new ReflectionClass($post);
                    $postClassName = $postReflection->getShortName();
                    $existingPageMeta = App\Postmeta::where(['post_id' => $post->id, 'post_type' => $postClassName, 'meta_key' => $meta_key])->first();
                    if (!empty($existingPageMeta)) { // Get existing post meta and update
                        
                        // Delete old file if exists
                        Storage::delete("public/$meta_file_folder/$existingPostMetaFile->meta_value");

                        $existingPageMeta->meta_value = is_array($post_meta_value) ? serialize(array_values($post_meta_value)) : $post_meta_value;
                        $existingPageMeta->save();
                    } else { // Save new post meta
                        $newPageMeta = new App\Postmeta();
                        $newPageMeta->post_id = $post->id;
                        $newPageMeta->post_type = $postClassName;
                        $newPageMeta->meta_key = $meta_key;
                        $newPageMeta->meta_value = is_array($post_meta_value) ? serialize(array_values($post_meta_value)) : $post_meta_value;
                        $newPageMeta->save();
                    }
                }
            }
        }
    }

    /**
     * Save file metas
     */
    if(!function_exists('save_file_metas')) {
        function save_file_metas($post, array $meta_files) {
            if(count($meta_files) > 0) { 
                foreach($meta_files as $meta_file_key => $meta_file) {
                    if(file_exists($meta_file)) {
        
                        // Save the file in storage
                        $post_meta_file_name = save_file($meta_file, 'posts_meta_files');
        
                        // Get existing meta file
                        $postReflection = new ReflectionClass($post);
                        $postClassName = $postReflection->getShortName();
                        $existingPostMetaFile = App\Postmeta::where(['post_id' => $post->id, 'meta_key' => $meta_file_key, 'post_type' => $postClassName])->first();
                        if(!empty($existingPostMetaFile->meta_value) ) { 
        
                            // Delete old file
                            Storage::delete('public/posts_meta_files/'.$existingPostMetaFile->meta_value);
        
                            // Update file name in meta table
                            $existingPostMetaFile->meta_value = $post_meta_file_name;
                            $existingPostMetaFile->save();
        
                        }
                        else {
                            // Save as new post meta
                            $newPostFileMeta = new App\Postmeta();
                            $newPostFileMeta->post_id = $post->id;
                            $newPostFileMeta->post_type = $postClassName;
                            $newPostFileMeta->meta_key = $meta_file_key;
                            $newPostFileMeta->meta_value = $post_meta_file_name;
                            $newPostFileMeta->save();
                        }
                    }
                }
            }
        }
    }

    /**
     * Delete metas
     */
    if(!function_exists('delete_metas')) {
        function delete_metas($post) {
            $postReflection = new ReflectionClass($post);
            $postClassName = $postReflection->getShortName();
            $post_metas = App\Postmeta::where(['post_id' => $post->id, 'post_type' => $postClassName])->get();
            foreach ($post_metas as $post_meta) {
                $post_meta->delete();
            }
        }
    }
    

    /**get_meta($post, 'telephone_two')     
     * Get if its api request
     * make request available for both browser and ajax
     */
    if(!function_exists('isApiRequest')) {
        function isApiRequest($request) {
            return $request->is('api/*') || $request->wantsJson();
        }
    }

    /**
     * Get File url
     * Function to generate file link for API use
     */
    if(!function_exists('getFilewUrl')) {
        function getFileUrl($file_name, $file_folder = null) {
            if($file_name) {
                if($file_folder) {
                    return Request::root() . '/storage' . '/' . $file_folder . '/' . $file_name;
                } else {
                    return Request::root() . '/storage' . '/' . $file_name;
                }
            }
            return null;
        }
    }