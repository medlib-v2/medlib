<?php

namespace Medlib\Traits;


trait UserPreferences
{
    /**
     * Get a preference item of the current user.
     *
     * @param string $key
     *
     * @return string|null
     */
    public function getPreference($key)
    {
        return array_get((array) unserialize($this->attributes['preferences']), $key);
    }
    /**
     * Save a user preference.
     *
     * @param string $key
     * @param string $val
     */
    public function savePreference($key, $val)
    {
        $preferences = $this->preferences;
        $preferences[$key] = $val;
        $this->preferences = $preferences;
        $this->save();
    }
    /**
     * An alias to savePreference().
     *
     * @see $this::savePreference
     *
     * @param $key
     * @param $val
     */
    public function setPreference($key, $val)
    {
        return $this->savePreference($key, $val);
    }
    /**
     * Delete a preference.
     *
     * @param string $key
     */
    public function deletePreference($key)
    {
        $preferences = $this->preferences;
        array_forget($preferences, $key);
        $this->update(compact('preferences'));
    }

    /**
     * User preferences are stored as a serialized associative array.
     *
     * @param array $value
     */
    public function setPreferencesAttribute($value)
    {
        $this->attributes['preferences'] = serialize($value);
    }
    /**
     * Unserialize the user preferences back to an array before returning.
     *
     * @param string $value
     *
     * @return array
     */
    public function getPreferencesAttribute($value)
    {
        $preferences = unserialize($value) ?: [];
        // Hide the user's secrets away!
        foreach ($this->hiddenPreferences as $key) {
            if (array_key_exists($key, $preferences)) {
                $preferences[$key] = 'hidden';
            }
        }
        return $preferences;
    }
}