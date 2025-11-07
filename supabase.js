import { createClient } from '@supabase/supabase-js'

const SUPABASE_URL = 'https://jdkouonxnopytjpwhzlb.supabase.co'
const SUPABASE_ANON_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Impka291b254bm9weXRqcHdoemxiIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NjE5MDg0MDcsImV4cCI6MjA3NzQ4NDQwN30.m-7tRTJmwONH1DzQKI4pHCcv_qDeIdtrj1DmV2sOjpU'

export const supabase = createClient(SUPABASE_URL, SUPABASE_ANON_KEY)